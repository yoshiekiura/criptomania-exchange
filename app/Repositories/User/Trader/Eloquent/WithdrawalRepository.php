<?php

namespace App\Repositories\User\Trader\Eloquent;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Models\User\Withdrawal;
use App\Repositories\BaseRepository;
use DataTables;


class WithdrawalRepository extends BaseRepository implements WithdrawalInterface
{
    /**
    * @var Withdrawal
    */
     protected $model;

     public function __construct(Withdrawal $withdrawal)
     {
        $this->model = $withdrawal;
     }

     public function getLast24hrWithrawalAmount(array $conditions)
     {
         return $this->model->where($conditions)->where('created_at', '>=', now()->subDay())->sum('amount');
     }

     public function withdrawAll()
     {
        return $this->model->all();
     }

     public function withdrawalCryptoCurrency()
     {
       $query = $this->model->join('stock_items', 'stock_items.id', '=', 'withdrawals.stock_item_id')
                            ->join('users', 'users.id', '=', 'withdrawals.user_id')
                            ->where('stock_items.item_type', CURRENCY_CRYPTO)
                            ->select([
                              'withdrawals.*',
                              'item',
                              'item_name',
                              'email'
                            ])->orderBy('withdrawals.created_at', 'desc')->get();
        return DataTables::of($query)
                          ->addIndexColumn()
                          ->editColumn('stock-name',function($stockItem){
                            return $stockItem->item_name.'('.$stockItem->item.')';
                          })
                          ->editColumn('amount',function($amount){
                            return $amount->amount.'<span class="strong">'.$amount->item.'</span>';
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                            </span>';

                            return $span;
                          })
                          ->editColumn('email',function($user){
                            if(has_permission('users.show')){
                              $email = '<a href="'.route('users.show', $user->user_id).'">'.$user->email.'</a>';
                            }
                            else{
                              $email = $transaction->email;
                            }
                            return $email;
                          })->addColumn('action',function($row){
                              $btn = '<div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                          <ul class="dropdown-menu pull-right">';
                                          if(has_permission('admin.review-withdrawals.show')){
                                              $btn .= '<li><a href="'.route('admin.review-withdrawals.show', $row->id).'">
                                                          <i class="fa fa-eye"></i>'.__('Show').'</a>
                                                      </li>';
                                          }

                              $btn .=      '</ul>
                                      </div>';

                              return $btn;
                          })->rawColumns(['stock-name','amount','status','email','action'])->make(true);

     }
}
