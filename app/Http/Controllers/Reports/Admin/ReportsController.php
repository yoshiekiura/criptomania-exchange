<?php

namespace App\Http\Controllers\Reports\Admin;

use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Admin\ReportsService;
use App\Http\Controllers\Controller;
use App\Models\Backend\StockExchange;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;


class ReportsController extends Controller
{
    private $reportsService;
    private $depositRepository;
    private $withdrawalRepository;
    private $depoBankRepo;
    private $model;

    public function __construct(StockExchange $model,DepositInterface $deposit, WithdrawalInterface $withdrawal, ReportsService $reportsService, DepositBankInterface $depoBank)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->reportsService = $reportsService;
        $this->depoBankRepo = $depoBank;
        $this->model = $model;
    }

    public function allDeposits($paymentTransactionType = null)
    {
        $data['list'] = $this->reportsService->deposits(null, null, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit', $data);
    }

    public function deposits($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->deposits(null, $id, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

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
        $data['list'] = $this->reportsService->depositBankTransfer(null, null, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit_bank', $data);
    }

    public function depositsBank($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->depositBankTransfer(null, $id, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.deposit_bank', $data);
    }

    public function allWithdrawals($paymentTransactionType = null) {
        $data['list'] = $this->reportsService->withdrawals(null, null, $paymentTransactionType);
        $data['title'] = __('Withdrawals');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_withdrawal', $data);
    }

    public function withdrawals($id, $paymentTransactionType = null) {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->withdrawals(null, $id, $paymentTransactionType);
        $data['title'] = __('Withdrawals');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.withdrawal', $data);
    }

    public function allTrades($categoryType = null) {
        // $data['list'] = $this->reportsService->trades(null, $categoryType);
        // $data['title'] = __('Trades');
        $userId = null;
        $data['categoryType'] = $categoryType;
        $data['user'] = $userId;

        return view('backend.reports.trades', $data);
    }

    public function tradesJson($userId = null, $categoryType = null, $stockPairId = null)
    {
      $row = config('commonconfig.category_slug.'.$categoryType);
      $query = $this->model->join('stock_pairs', 'stock_pairs.id', '=', 'stock_exchanges.stock_pair_id')
                            ->join('stock_orders', 'stock_orders.id', '=', 'stock_exchanges.stock_order_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_exchanges.user_id');
                            if(!is_null($userId))
                            {
                              $query->where('stock_exchanges.user_id', $userId);
                            }
                            if(!is_null($stockPairId))
                            {
                              $query->where('stock_orders.stock_pair_id',$stockPairId);
                            }
                            $data = $query->select([

                                  'stock_exchanges.*',
                                  // config('commonconfig.category_slug.','stock_orders.category'),
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
                                // return $data;


                            // $dec = json_decode($data);

              return Datatables::of($data)
                                ->addIndexColumn()
                                ->addColumn('coin-pair',function($pair){
                                  return $pair->stock_item_abbr.'/'.$pair->base_item_abbr;
                                })
                                ->editColumn('exchange_type',function($exchange){
                                  return exchange_type($exchange->exchange_type);
                                })
                                ->editColumn('category',function($category) use ($categoryType){
                                  if(!$categoryType)
                                  {
                                    $row = category_type($category->category);
                                  }
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

        return view('backend.reports.trades', $data);
    }

    public function openOrders($userId)
    {
        $data['list'] = $this->reportsService->openOrders($userId);
        $data['title'] = __('Open Orders');
        $data['hideUser'] = $userId;

        return view('backend.reports.open_orders', $data);
    }

    public function tradesByStockPairId($id, $categoryType = null) {
        $data['list'] = $this->reportsService->trades(null, $categoryType, $id);
        $data['title'] = __('Trades');
        $data['categoryType'] = $categoryType;

        return view('backend.reports.trades', $data);
    }

    public function openOrdersByStockPairId($id)
    {
        $data['list'] = $this->reportsService->openOrders(null, null, $id);
        $data['title'] = __('Open Orders');
        $data['hideUser'] = false;

        return view('backend.reports.open_orders', $data);
    }
}
