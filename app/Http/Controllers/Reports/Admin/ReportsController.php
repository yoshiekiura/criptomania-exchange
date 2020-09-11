<?php

namespace App\Http\Controllers\Reports\Admin;

use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Admin\ReportsService;
use App\Http\Controllers\Controller;
use App\Models\Backend\StockExchange;
use Illuminate\Support\Facades\DB;
use App\Models\User\Deposit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use App\Models\User\StockOrder;


class ReportsController extends Controller
{
    private $reportsService;
    private $depositRepository;
    private $withdrawalRepository;
    private $depoBankRepo;
    private $depositModel;
    private $model;
    private $stockOrder;

    public function __construct(StockExchange $model,DepositInterface $deposit, WithdrawalInterface $withdrawal, ReportsService $reportsService, DepositBankInterface $depoBank, Deposit $depositModel, StockOrder $stockOrder)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->reportsService = $reportsService;
        $this->depoBankRepo = $depoBank;
        $this->model = $model;
        $this->$depositModel = $depositModel;
        $this->stockOrder = $stockOrder;

    }

    public function allDeposits($paymentTransactionType = null)
    {
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit', $data);
    }

    public function deposits($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['status'] = $paymentTransactionType;
        $data['walletId'] = $id;

        return view('backend.reports.deposit', $data);
    }

     public function editBankDepoStatus($id)
    {
        $data['title'] = __('Edit Status');
        $data['list'] = $this->depoBankRepo->findOrFailById($id);

        return view('backend.reports.changeStatus', $data);
    }

    public function allDepositsBank($paymentTransactionType = null)
    {
        // $data['list'] = $this->reportsService->depositBankTransfer(null, null, $paymentTransactionType);
        // $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit_bank', $data);
    }

    public function depositBankTraderJson($id = null, $userId = null, $transactionType = null)
    {

        $query = DB::table('deposit_bank_transfer')->join('stock_items', 'stock_items.id', '=', 'deposit_bank_transfer.stock_item_id')
                                    ->join('users', 'users.id', '=', 'deposit_bank_transfer.users_id')
                                    ->join('list_bank','list_bank.id', '=' ,'deposit_bank_transfer.admin_bank_id');
                                    if(!is_null($userId)){
                                        $query->where('users_id',$userId);
                                    }
                                    if(!is_null($id)){
                                        $query->where('wallet_id',$id);
                                    }
                                    if(!is_null($transactionType)){
                                        $query->where('status',config('commonconfig.payment_slug.' . $transactionType));
                                    }
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
                          })->editColumn('payment-prove',function($payment){
                                    if($payment->payment_prove != NULL){
                                       $show = '<a href="#" data-id='.$payment->id.' data-struck='.get_struck($payment->payment_prove).'
                                                            data-toggle="modal" data-target="#modal-insert" class="show-struck">'.$payment->payment_prove.'</a>';
                                      }
                                    else{
                                    $show = "<span class='strong'>The User Doesn't have a Payment Prove</span>";
                                    }

                                    return $show;
                          })
                          ->addColumn('action', function($row){
                                  $btn = '<div class="btn-group pull-right">
                                              <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                      data-toggle="dropdown">
                                                  <i class="fa fa-gear"></i>
                                              </button>
                                          <ul class="dropdown-menu dropdown-menu-stock-pair pull-right">';
                                          if(has_permission('admin.users.wallets.editBankBalance')){
                                            $btn .= '<li>
                                                      <a href='.route('admin.users.wallets.editBankBalance', [$row->users_id, $row->wallet_id, $row->id]).'"><i
                                                                  class="fa fa-eye"></i>'.__('Reviews').'</a>
                                                    </li>';
                                          }
                                          return $btn;
                          })
                          ->rawColumns(['amount','status','email','bank-admin','payment-prove','action'])->make(true);
        
    }


    public function withdrawalsTraderJson($id = null, $userId = null, $transactionType = null)
    {

        $query = DB::table('withdrawals')->join('stock_items', 'stock_items.id', '=', 'withdrawals.stock_item_id')
                                    ->join('users', 'users.id', '=', 'withdrawals.user_id');
                                    if(!is_null($userId)){
                                        $query->where('user_id',$userId);
                                    }
                                    if(!is_null($id)){
                                        $query->where('wallet_id',$id);
                                    }
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
                          })
                          ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                            $href = "<a href=".route('users.show', $user->user_id).">".$user->email."</a>";
                                    }
                                    else{
                                         $href = $user->email;
                                    }

                                    return $href;
                                    
                          })->rawColumns(['amount','status','email'])->make(true);
        
    }

    public function depositTraderJson($id = null, $userId = null, $paymentType = null)
    {

        $query = DB::table('deposits')->join('stock_items', 'stock_items.id', '=', 'deposits.stock_item_id')
                                    ->join('users', 'users.id', '=', 'deposits.user_id');
                                    if(!is_null($userId)){
                                        $query->where('user_id',$userId);
                                    }
                                    if(!is_null($id)){
                                        $query->where('wallet_id',$id);
                                    }
                                    if(!is_null($paymentType)){
                                        $query->where('status',config('commonconfig.payment_slug.' . $paymentType));
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
                          })
                          ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                            $href = "<a href=".route('users.show', $user->user_id).">".$user->email."</a>";
                                    }
                                    else{
                                         $href = $user->email;
                                    }

                                    return $href;
                                    
                          })
                          ->rawColumns(['amount','status','email'])->make(true);
        
    }

    public function depositsBank($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['walletId'] = $id;

        return view('backend.reports.deposit_bank', $data);
    }

    public function allWithdrawals($paymentTransactionType = null) {
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_withdrawal', $data);
    }

    public function withdrawals($id, $paymentTransactionType = null) {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['status'] = $paymentTransactionType;
        $data['walletId'] = $id;

        return view('backend.reports.withdrawal', $data);
    }

    public function allTrades($categoryType = null) {
        // $data['list'] = $this->reportsService->trades(null, $categoryType);
        // $data['title'] = __('Trades');
        $userId = null;
        $stockPairId = null;
        $data['categoryType'] = $categoryType;
        $data['user'] = $userId;
        if(!$stockPairId){
          $data['stockPairId'] = $stockPairId;
        }
        $data['stockPair'] = DB::table('stock_pairs')->leftJoin('stock_items as base_item', 'base_item.id', '=', 'stock_pairs.base_item_id')
                                                     ->leftJoin('stock_items as stock_item', 'stock_item.id', '=', 'stock_pairs.stock_item_id')
                                                     ->select([
                                                                  'stock_item.item as stock_item_abbr',
                                                                  'base_item.item as base_item_abbr',
                                                     ])->get();

        return view('backend.reports.trades', $data);
    }

    public function tradesJson($userId, $categoryType = null)
    {
      $query = $this->model->join('stock_pairs', 'stock_pairs.id', '=', 'stock_exchanges.stock_pair_id')
                            ->join('stock_orders', 'stock_orders.id', '=', 'stock_exchanges.stock_order_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_exchanges.user_id');
                            if(!is_null($userId))
                            {
                              $query->where('stock_exchanges.user_id', $userId);
                            }
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

    public function trades($userId, $categoryType = null) {
        // $data['list'] = $this->reportsService->trades($userId, $categoryType);
        $data['title'] = __('Trades');
        $data['categoryType'] = $categoryType;
        $data['user'] = $userId;
        $data['stockPair'] = DB::table('stock_pairs')->leftJoin('stock_items as base_item', 'base_item.id', '=', 'stock_pairs.base_item_id')
                                                     ->leftJoin('stock_items as stock_item', 'stock_item.id', '=', 'stock_pairs.stock_item_id')
                                                     ->select([
                                                                  'stock_item.item as stock_item_abbr',
                                                                  'base_item.item as base_item_abbr',
                                                     ])->get();
        return view('backend.reports.trades', $data);
    }

    public function openOrders($userId = null)
    {
        if(!is_null($userId)){
          $data['hideUser'] = $userId;
        }
        else{
          $data['hideUser'] = null;
        }

        return view('backend.reports.open_orders', $data);
    }

    public function openOrdersJson($userId = null)
    {
      $query = $this->stockOrder->join('stock_pairs', 'stock_pairs.id', '=', 'stock_orders.stock_pair_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_orders.user_id');
                            if(!is_null($userId)){
                               $query->where('stock_orders.user_id', $userId);
                            }
                           $query->where('stock_orders.status', '<', STOCK_ORDER_COMPLETED);
                           $data = $query->select([
                                    'stock_orders.*',
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
                                ->editColumn('price',function($price){
                                  $span = $price->price.' '.'<span class="strong">'.$price->base_item_abbr.'</span>';
                                  return $span;
                                })
                                ->editColumn('amount',function($amount){
                                  $span = $amount->amount.' '.'<span class="strong">'.$amount->stock_item_abbr.'</span>';
                                  return $span;
                                })
                                ->editColumn('total',function($total){
                                  $span = bcmul($total->amount, $total->price).' '.'<span class="strong">'.$total->base_item_abbr.'</span>';

                                  return $span;
                                })
                                ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                      $email = '<a href="'.route('users.show', $user->id).'">'.$user->email.'</a>';
                                    }
                                    else{
                                      $email = $user->email;
                                    }
                                    return $email;
                                })->editColumn('stop-limit',function($limit){
                                      if(!is_null($limit->stop_limit))
                                      {
                                       $span = $limit->stop_limit.' '.'<span class="strong">'.$limit->base_item_abbr.'</span>';
                                      }
                                      else{
                                        $span = '-';
                                      }

                                      return $span;
                                      
                                })
                                ->rawColumns(['coin-pair','exchange_type','category','price','amount','total','email','stop-limit'])
                                ->make(true);

    }

    public function tradesByStockPairId($id) {
        $data['stockPairId'] = $id;

        return view('backend.reports.tradesStockPair', $data);
    }

    public function stockPairTraderJson($stockPairId)
    {
      $query = $this->model->join('stock_pairs', 'stock_pairs.id', '=', 'stock_exchanges.stock_pair_id')
                            ->join('stock_orders', 'stock_orders.id', '=', 'stock_exchanges.stock_order_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_exchanges.user_id')
                            ->where('stock_orders.stock_pair_id',$stockPairId)
                            // ->where('stock_orders.status', '<', STOCK_ORDER_COMPLETED)
                            ->select([

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

              return Datatables::of($query)
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
                                })
                                ->editColumn('stop-limit',function($limit){
                                      if(!is_null($limit->stop_limit))
                                      {
                                       $span = $limit->stop_limit.' '.'<span class="strong">'.$limit->base_item_abbr.'</span>';
                                      }
                                      else{
                                        $span = '-';
                                      }

                                      return $span;
                                      
                                })
                                ->rawColumns(['coin-pair','exchange_type','category','referral','email','stop-limit'])
                                ->make(true);

    }

    public function openOrdersStockPairJson($stockPairId)
    {
      $query = $this->stockOrder->join('stock_pairs', 'stock_pairs.id', '=', 'stock_orders.stock_pair_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_orders.user_id')
                            ->where('stock_orders.stock_pair_id',$stockPairId)
                            ->where('stock_orders.status', '<', STOCK_ORDER_COMPLETED);
                           $data = $query->select([
                                    'stock_orders.*',
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
                                ->editColumn('price',function($price){
                                  $span = $price->price.' '.'<span class="strong">'.$price->base_item_abbr.'</span>';
                                  return $span;
                                })
                                ->editColumn('amount',function($amount){
                                  $span = $amount->amount.' '.'<span class="strong">'.$amount->stock_item_abbr.'</span>';
                                  return $span;
                                })
                                ->editColumn('total',function($total){
                                  $span = bcmul($total->amount, $total->price).' '.'<span class="strong">'.$total->base_item_abbr.'</span>';

                                  return $span;
                                })
                                ->editColumn('email',function($user){
                                    if(has_permission('users.show')){
                                      $email = '<a href="'.route('users.show', $user->id).'">'.$user->email.'</a>';
                                    }
                                    else{
                                      $email = $user->email;
                                    }
                                    return $email;
                                })->editColumn('stop-limit',function($limit){
                                      if(!is_null($limit->stop_limit))
                                      {
                                       $span = $limit->stop_limit.' '.'<span class="strong">'.$limit->base_item_abbr.'</span>';
                                      }
                                      else{
                                        $span = '-';
                                      }

                                      return $span;
                                      
                                })
                                ->rawColumns(['coin-pair','exchange_type','category','price','amount','total','email','stop-limit'])
                                ->make(true);

    }
    public function openOrdersByStockPairId($id)
    {
        // $data['list'] = $this->reportsService->openOrders(null, null, $id);
        // $data['title'] = __('Open Orders');
        $data['hideUser'] = false;
        $data['stockPairId'] = $id;

        return view('backend.reports.open_orders_stock_pair', $data);
    }


}
