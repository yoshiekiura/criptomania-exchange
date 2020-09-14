<?php

namespace App\Http\Controllers\Reports\Trader;

use App\Http\Controllers\Controller;
use App\Repositories\User\Interfaces\UserInfoInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Models\Backend\StockExchange;
use App\Models\User\Deposit;
use App\Services\User\Admin\ReportsService;
use Illuminate\Support\Facades\DB;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\User\ReferralEarning;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReportsController extends Controller
{
    private $reportsService;
    private $depositRepository;
    private $depoBankRepo;
    private $model;
    private $depositModel;
    private $withdrawalRepository;
    private $userModel;
    private $referralEarning;

    public function __construct(DepositInterface $deposit, StockExchange $model, Deposit $depositModel, WithdrawalInterface $withdrawal, ReportsService $reportsService,DepositBankInterface $depoBank, User $userModel, ReferralEarning $referralEarning)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->depoBankRepo = $depoBank;
        $this->model = $model;
        $this->reportsService = $reportsService;
        $this->referralEarning = $referralEarning;
        $this->userModel = $userModel;
    }

    /*

    * @desc   : Every function which end with "Json" is for send data to datatable
      @param  : in depositTraderJson($id, transactionType = null), depositBankTraderJson($id, transactionType = null),
                withdrawalsTraderJson($id, transactionType = null). Parameter $id in this function is for checking user id and $transactionType to check transaction type is null or not. $categoryType in function tradesJson is for checking payment type category
      @return : all of function which end with "Json" will returning data for DataTables.

    */

    public function allDepositTraderJson()
    {

        $query = DB::table('deposits')->join('stock_items', 'stock_items.id', '=', 'deposits.stock_item_id')
                                    ->join('users', 'users.id', '=', 'deposits.user_id')->where('user_id',Auth::id());
                $data = $query->select([
                        'deposits.*', 
                        'item', 
                        'item_name', 
                        'email'
                ])->get();

        return Datatables::of($data)
                          ->addIndexColumn()
                          ->editColumn('amount',function($amount){
                            $span = $amount->amount.' '.'<span class="strong">'.$amount->item.'</span>';
                            return $span;
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                                    </span>';
                            return $span;
                          })->rawColumns(['amount','status','email'])->make(true);
        
    }

    public function depositTraderJson($id, $transactionType = null)
    {

        $query = DB::table('deposits')->join('stock_items', 'stock_items.id', '=', 'deposits.stock_item_id')
                                    ->join('users', 'users.id', '=', 'deposits.user_id')
                                    ->where('user_id',Auth::id())
                                    ->where('wallet_id',$id);
                                    if(!is_null($transactionType)){
                                        $query->where('status',config('commonconfig.payment_slug.' . $transactionType));
                                    }
                $data = $query->select([
                        'deposits.*', 
                        'item', 
                        'item_name', 
                        'email'
                ])->get();

         return Datatables::of($data)
                          ->addIndexColumn()
                          ->editColumn('amount',function($amount){
                            $span = $amount->amount.' '.'<span class="strong">'.$amount->item.'</span>';
                            return $span;
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                                    </span>';
                            return $span;
                          })->rawColumns(['amount','status','email'])->make(true);
        
    }

    public function depositBankTraderJson($id, $transactionType = null)
    {

        $query = DB::table('deposit_bank_transfer')->join('stock_items', 'stock_items.id', '=', 'deposit_bank_transfer.stock_item_id')
                                    ->join('users', 'users.id', '=', 'deposit_bank_transfer.users_id')
                                    ->join('list_bank','list_bank.id', '=' ,'deposit_bank_transfer.admin_bank_id')
                                    ->where('users_id',Auth::id())
                                    ->where('wallet_id',$id);

                $data = $query->select([
                         'deposit_bank_transfer.*',
                         'item', 
                         'item_name',
                         'email',
                         'bank_name',
                         'account_number',
                         'payment_prove'
                ])->orderBy('created_at', 'desc')->get();

        return Datatables::of($data)
                          ->addIndexColumn()
                          ->editColumn('amount',function($amount){
                            $span = $amount->amount.' '.'<span class="strong">'.$amount->item.'</span>';
                            return $span;
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                                    </span>';
                            return $span;
                          })
                          ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                            $href = "<a href=".route('users.show', $user->users_id).">".$user->email."</a>";
                                    }
                                    else{
                                         $href = $user->email;
                                    }

                                    return $href;
                                    
                          })->editColumn('bank-admin',function($admin){
                                    if(has_permission('admin.list-bank.show')){
                                     $href = '<a href='.route('admin.list-bank.show', $admin->admin_bank_id).'>'.$admin->bank_name.'</a>';
                                    }
                                    else{
                                     $href = $admin->bank_name;
                                    }

                                    return $href;
                          })
                          ->editColumn('payment-prove', function($row){
                                if($row->payment_prove == NULL){
                                   
                                    if($row->status == PAYMENT_PENDING){

                                         if(has_permission('trader.wallets.deposit.struckUpload')){

                                          return '<form action="'.route('trader.wallets.deposit.struckUpload', $row->id).'" method="POST"
                                                      class="validator enctype="multipart/form-data id="form_struck">
                                                          <input type="file" name="'.fake_field('payment-prove').'" id="'.fake_field('payment-prove').'"
                                                            data-cval-name="The Patment Prove" data-cval-rules="files:jpg,png,jpeg|max:2048">
                                                          <input type="submit" value="submit">
                                                    </form>';
                                        } 
                                    }
                                    else if($row->status == PAYMENT_COMPLETED){

                                          return '<span class="label" style="color:black;">This transaction has been completed</span>';
                                        }
                                    else if($row->status == PAYMENT_FAILED){
                                         return '<span class="label" style="color:black;">This transaction has been completed and your payment prove is invalid</span>';
                                    }

                                }

                                else{
                                
                                    return $row->payment_prove;

                                }

                                // return $show;
                          })
                          ->addColumn('action',function($row){
                                $btn = '<div class="btn-group pull-right">
                                                <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    <i class="fa fa-gear"></i>
                                                </button>
                                            <ul class="dropdown-menu pull-right">';
                                    if(has_permission('trader.wallets.invoice')){
                                    $btn .= '<li>
                                                <a href='.route('trader.wallets.invoice', [$row->id, $row->wallet_id,$row->id]).'><i
                                                            class="fa fa-eye"></i>'.__('Show').'</a>
                                            </li>';
                                    }

                                    return $btn;
                          })
                          ->rawColumns(['amount','status','email','bank-admin','payment-prove','action'])->make(true);
        
    }
    public function withdrawalsTraderWalletJson($id, $transactionType = null)
    {

        $query = DB::table('withdrawals')->join('stock_items', 'stock_items.id', '=', 'withdrawals.stock_item_id')
                                    ->join('users', 'users.id', '=', 'withdrawals.user_id')
                                    ->where('user_id',Auth::id())
                                    ->where('wallet_id',$id);
                                    if(!is_null($transactionType)){
                                        $query->where('status',config('commonconfig.payment_slug.' . $transactionType));
                                    }
                $data = $query->select([
                         'withdrawals.*',
                         'item', 
                         'item_name',
                         'email',
                ])->orderBy('created_at', 'desc')->get();

        return Datatables::of($data)
                          ->addIndexColumn()
                          ->editColumn('amount',function($amount){
                            $span = $amount->amount.' '.'<span class="strong">'.$amount->item.'</span>';
                            return $span;
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                                    </span>';
                            return $span;       
                          })->rawColumns(['amount','status'])->make(true);
        
    }

    public function withdrawalsTraderJson()
    {

        $query = DB::table('withdrawals')->join('stock_items', 'stock_items.id', '=', 'withdrawals.stock_item_id')
                                    ->join('users', 'users.id', '=', 'withdrawals.user_id')
                                    ->where('user_id',Auth::id())
                                    ->select([
                                             'withdrawals.*',
                                             'item', 
                                             'item_name',
                                             'email',
                                    ])->orderBy('created_at', 'desc')->get();

        return Datatables::of($query)
                          ->addIndexColumn()
                          ->editColumn('amount',function($amount){
                            $span = $amount->amount.' '.'<span class="strong">'.$amount->item.'</span>';
                            return $span;
                          })
                          ->editColumn('status',function($status){
                            $span = '<span class="label label-'.config('commonconfig.payment_status.' . $status->status . '.color_class').'">'.payment_status($status->status).'
                                    </span>';
                            return $span;       
                          })->rawColumns(['amount','status'])->make(true);
        
    }

    public function tradesJson($categoryType = null)
    {
      $query = $this->model->join('stock_pairs', 'stock_pairs.id', '=', 'stock_exchanges.stock_pair_id')
                            ->join('stock_orders', 'stock_orders.id', '=', 'stock_exchanges.stock_order_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_exchanges.user_id')
                            ->where('stock_exchanges.user_id', Auth::id());
                            if(!is_null($categoryType)){
                              $query->where('stock_orders.category',config('commonconfig.category_slug.' . $categoryType));
                            }
                            $data = $query->select([

                                  'stock_exchanges.*',
                                  'stock_orders.category',
                                  'stock_orders.maker_fee',
                                  'stock_orders.taker_fee',
                                  // stock item
                                  'stock_items.id as stock_item_id',
                                  'stock_items.item as stock_item_abbr',
                                  'stock_items.item_name as stock_item_name',
                                  'stock_items.item_type as stock_item_type',
                                  // base item
                                  'base_items.id as base_item_id',
                                  'base_items.item as base_item_abbr',
                                  'base_items.item_name as base_item_name',
                                  'base_items.item_type as base_item_type',
                                  'email',

                                ])->get();

                                // dd($data);


                            // $dec = json_decode($data);

              return Datatables::of($data)
                                ->addIndexColumn()
                                ->addColumn('coin-pair',function($pair){
                                  return $pair->stock_item_abbr.'/'.$pair->base_item_abbr;
                                })
                                ->editColumn('exchange_type',function($exchange){
                                  return exchange_type($exchange->exchange_type);
                                })
                                ->editColumn('category',function($category){

                                    $row = category_type($category->category);
            
                                  return $row;

                                })
                                ->editColumn('referral',function($referral){
                                  if($referral->is_maker == 1)
                                  {
                                    $maker = number_format($referral->maker_fee, 2);
                                  }
                                  else{
                                    $maker = number_format($referral->taker_fee, 2);
                                  }
                                  return bcadd($referral->fee,$referral->referral_earning).'('.$maker.'%)';
                                })
                                ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                      $email = '<a href="'.route('users.show', $user->id).'">'.$user->email.'</a>';
                                    }
                                    else{
                                      $email = $user->email;
                                    }
                                    return $email;
                                })->rawColumns(['coin-pair','exchange_type','category','referral','email'])
                                ->make(true);

    }

    public function referralUsersJson()
    {
        // $data['list'] = $this->reportsService->referralUsers(Auth::id());

        $query = $this->userModel->join('user_infos', 'users.id', '=', 'user_infos.user_id')
                                 ->where('users.referrer_id',Auth::id())
                                 ->select([
                                            'users.id',
                                            'users.created_at',
                                            'user_infos.first_name',
                                            'user_infos.last_name',
                                          ])->get();

        return Datatables::of($query)
                           ->addIndexColumn()
                           ->addColumn('action', function($row){
                              $view = '<a class="btn btn-info btn-sm"
                                          href='.route('reports.trader.referral-earning', ['ref'=> encrypt($row->id)]).'>'.__("View Earning").'</a>';

                              return $view;
                           })
                           ->rawColumns(['action'])
                           ->make(true);
    }

    public function trades($categoryType = null)
    {
        $data['stockPair'] = DB::table('stock_pairs')->leftJoin('stock_items as base_item', 'base_item.id', '=', 'stock_pairs.base_item_id')
                                                     ->leftJoin('stock_items as stock_item', 'stock_item.id', '=', 'stock_pairs.stock_item_id')
                                                     ->select([
                                                                  'stock_item.item as stock_item_abbr',
                                                                  'base_item.item as base_item_abbr',
                                                     ])->get();
        $data['categoryType'] = $categoryType;

        return view('frontend.reports.trades', $data);
    }


    public function allDeposits()
    {    

        return view('frontend.reports.all_deposit');
    }

    public function deposits($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        $data['walletId'] = $id;
        $data['status'] = $paymentTransactionType;

        return view('frontend.reports.deposit', $data);
    }


    public function allDepositsBank($paymentTransactionType = null)
    {
        $data['list'] = $this->reportsService->depositBankTransfer(null, null, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('frontend.reports.all_deposit_bank', $data);
    }

    public function depositsBank($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        $data['walletId'] = $id;
        $data['status'] = $paymentTransactionType;

        return view('frontend.reports.deposit_bank', $data);
    }



    public function allWithdrawals($paymentTransactionType = null)
    {

        return view('frontend.reports.all_withdrawal');
    }

    public function withdrawals($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        $data['status'] = $paymentTransactionType;
        $data['walletId'] = $id;

        return view('frontend.reports.withdrawal', $data);
    }

    public function referralUsers()
    {
        $data['title'] = __('Trades');

        return view('frontend.reports.referral_users', $data);
    }

    public function referralEarning()
    {
      try {
            $userId = decrypt(request()->get('ref'));
        } catch (\Exception $exception) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Referral earning not found for this request.'));
        }

        if(request()->ajax())
        {
             $query = $this->referralEarning->join('stock_items', 'stock_items.id', '=', 'referral_earnings.stock_item_id')
                                       ->where('referrer_user_id',Auth::id())
                                       ->where('referral_user_id',$userId)
                                       ->select([
                                          'stock_items.item',
                                          'stock_items.item_name',
                                          'stock_items.item_emoji',
                                          DB::raw('sum(amount) as amount')

                                       ])
                                       ->groupBy('stock_items.item', 'stock_items.item_name', 'stock_items.item_emoji')
                                       ->get();
        return Datatables::of($query)
                           ->addIndexColumn()
                           ->editColumn('symbol', function($row){
                                if(get_item_emoji($row->item_emoji)){
                                   $data = '<img class="img-sm" src='.get_item_emoji($row->item_emoji).' alt="">';
                                }
                                else{
                                    $data = '<i class="fa fa-money fa-lg"></i>';
                                }

                                return $data;
                                       
                           })
                           ->editColumn('item',function($row){
                              $data = $row->item_name.'('. $row->item .')';
                              return $data;
                           })
                           ->editColumn('amount',function($row){
                              $data = $row->amount.' '.$row->item; 
                              return $data;
                           })
                           ->rawColumns(['symbol','item','amount'])->make(true);
        }
        $data = request()->get('ref');
        
        return view('frontend.reports.referral_earning')->with('data', $data);
    }
}