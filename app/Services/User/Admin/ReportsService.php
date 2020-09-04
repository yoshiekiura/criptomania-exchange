<?php

namespace App\Services\User\Admin;

use App\Repositories\Exchange\Interfaces\StockExchangeInterface;
use App\Repositories\User\Interfaces\UserInterface;
use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Repositories\User\Trader\Interfaces\ReferralEarningInterface;
use App\Repositories\User\Trader\Interfaces\StockOrderInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\StockExchange;
use Carbon\Carbon;
use DataTables;




class ReportsService
{
    private $depositRepository;
    private $withdrawalRepository;
    private $depositBankRepo;
    private $model;
    public function __construct(StockExchange $model, DepositInterface $deposit, WithdrawalInterface $withdrawal, DepositBankInterface $depositBank)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->depositBankRepo = $depositBank;
        $this->model = $model;
    }

    public function deposits($userId = null, $id = null, $transactionType = null)
    {
        $searchFields = [
            ['ref_id', __('Reference ID')],
            ['amount', __('Amount')],
            ['address', __('Address')],
            ['txn_id', __('Transaction ID')],
        ];

        if (is_null($id)) {
            $searchFields[] = ['item_name', __('Stock Name')];
        }

        $orderFields = [
            ['created_at', __('Date')],
        ];

        if (is_null($id)) {
            $orderFields[] = ['item_name', __('Stock Name')];
        }

        $where = null;

        if (!is_null($userId)) {
            $where['user_id'] = $userId;
        } else {
            $searchFields[] = ['email', __('Email')];
        }

        if (!is_null($transactionType)) {
            $where['status'] = config('commonconfig.payment_slug.' . $transactionType);
        }

        $select = ['deposits.*', 'item', 'item_name', 'email'];
        $joinArray = [
            ['stock_items', 'stock_items.id', '=', 'deposits.stock_item_id'],
            ['users', 'users.id', '=', 'deposits.user_id'],
        ];

        if (!is_null($id)) {
            $where['wallet_id'] = $id;
        }

        $query = $this->depositRepository->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function depositBankTransfer($userId = null, $id = null, $transactionType = null)
    {
        $searchFields = [
            ['ref_id', __('Reference ID')],
            ['amount', __('Amount')],
            ['admin_bank_id', __('Bank Name')],
            ['users_id', __('Trader Name')],
        ];

        if (is_null($id)) {
            $searchFields[] = ['item_name', __('Stock Name')];
        }

        $orderFields = [
            ['created_at', __('Date')],
        ];

        if (is_null($id)) {
            $orderFields[] = ['item_name', __('Stock Name')];
        }

        $where = null;

        if (!is_null($userId)) {
            $where['users_id'] = $userId;
        } else {
            $searchFields[] = ['email', __('Email')];
        }

        if (!is_null($transactionType)) {
            $where['status'] = config('commonconfig.payment_slug.' . $transactionType);
        }

        $select = ['deposit_bank_transfer.*', 'item', 'item_name', 'email','bank_name','account_number','payment_prove'];
        $joinArray = [
            ['stock_items', 'stock_items.id', '=', 'deposit_bank_transfer.stock_item_id'],
            ['users', 'users.id', '=', 'deposit_bank_transfer.users_id'],
            ['list_bank','list_bank.id', '=' ,'deposit_bank_transfer.admin_bank_id'],
        ];

        if (!is_null($id)) {
            $where['wallet_id'] = $id;
        }

        $query = $this->depositBankRepo->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function withdrawals($userId = null, $id = null, $transactionType = null)
    {
        $searchFields = [
            ['ref_id', __('Reference ID')],
            ['amount', __('Amount')],
            ['address', __('Address')],
            ['txn_id', __('Transaction ID')],
        ];

        if (is_null($id)) {
            $searchFields[] = ['item_name', __('Stock Name')];
        }

        $orderFields = [
            ['created_at', __('Date')],
        ];

        if (is_null($id)) {
            $orderFields[] = ['item_name', __('Stock Name')];
        }

        $where = null;

        if (!is_null($userId)) {
            $where['user_id'] = $userId;
        } else {
            $searchFields[] = ['email', __('Email')];
        }

        if (!is_null($transactionType)) {
            $where['status'] = config('commonconfig.payment_slug.' . $transactionType);
        }

        $select = ['withdrawals.*', 'item', 'item_name', 'email'];
        $joinArray = [
            ['stock_items', 'stock_items.id', '=', 'withdrawals.stock_item_id'],
            ['users', 'users.id', '=', 'withdrawals.user_id'],
        ];

        if (!is_null($id)) {
            $where['wallet_id'] = $id;
        }

        $query = $this->withdrawalRepository->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function trades($userId = null, $categoryType = null, $stockPairId = null)
    {
        $searchFields = [
            ['stock_exchanges.stock_pair_id', __('Market')],
        ];

        $orderFields = [
            ['stock_exchanges.created_at', __('Date')],
        ];

        $where = null;

        if (!is_null($userId)) {
            $where['stock_exchanges.user_id'] = $userId;
        }

        if (!is_null($categoryType)) {
            $where['stock_orders.category'] = config('commonconfig.category_slug.' . $categoryType);

        }

        if (!is_null($stockPairId)) {
            $where['stock_orders.stock_pair_id'] = $stockPairId;
        }

        $select = [
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
        ];
        $joinArray = [
            ['stock_pairs', 'stock_pairs.id', '=', 'stock_exchanges.stock_pair_id'],
            ['stock_orders', 'stock_orders.id', '=', 'stock_exchanges.stock_order_id'],
            ['stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id'],
            ['stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id'],
            ['users', 'users.id', '=', 'stock_exchanges.user_id'],
        ];

        $query = app(StockExchangeInterface::class)->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function tradesJson($userId = null, $categoryType = null, $stockPairId = null)
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
                            if(!is_null($stockPairId))
                            {
                              $query->where('stock_orders.stock_pair_id',$stockPairId);
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


                            // $dec = json_decode($data);

              return Datatables::of($data)
                                ->addIndexColumn()
                                ->addColumn('coin-pair',function($pair){
                                  return $pair->stock_item_abbr.'/'.$pair->base_item_abbr;
                                })
                                ->editColumn('exchange_type',function($exchange){
                                  return exchange_type($exchange->exchange_type);
                                })
                                ->addColumn('category',function($category) use ($categoryType){
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
    public function openOrders($userId = null, $categoryType = null, $stockPairId = null)
    {
        $searchFields = [
            ['stock_orders.stock_pair_id', __('Market')],
            ['stock_orders.price', __('Price')],
            ['stock_orders.amount', __('Amount')],
        ];

        if (is_null($userId)) {
            $searchFields[] = ['stock_orders.user_id', __('User')];
        }

        $orderFields = [
            ['stock_orders.price', __('Price')],
            ['stock_orders.amount', __('Amount')],
            ['stock_order.created_at', __('Date')],
        ];

        $where = [
            ['stock_orders.status', '<', STOCK_ORDER_COMPLETED]
        ];

        if (!is_null($userId)) {
            $where[] = ['stock_orders.user_id' => $userId];
        } else {
            $searchFields[] = ['email', __('Email')];
        }

        if (!is_null($stockPairId)) {
            $where['stock_orders.stock_pair_id'] = $stockPairId;
        }

        if (!is_null($categoryType)) {
            $where['stock_orders.category'] = config('commonconfig.category_slug.' . $categoryType);
        }

        $select = [
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
        ];
        $joinArray = [
            ['stock_pairs', 'stock_pairs.id', '=', 'stock_orders.stock_pair_id'],
            ['stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id'],
            ['stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id'],
            ['users', 'users.id', '=', 'stock_orders.user_id'],
        ];

        $query = app(StockOrderInterface::class)->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function referralUsers($id)
    {
        $searchFields = [
            ['user_infos.first_name', __('First Name')],
            ['user_info.last_name', __('Last Name')],
        ];

        $orderFields = [
            ['user_infos.first_name', __('First Name')],
            ['user_info.last_name', __('Last Name')],
            ['users.created_at', __('Registration Date')],
        ];

        $where['users.referrer_id'] = $id;

        $select = [
            'users.id',
            'users.created_at',
            'user_infos.first_name',
            'user_infos.last_name',
        ];
        $joinArray = [
            ['user_infos', 'users.id', '=', 'user_infos.user_id'],
        ];

        $query = app(UserInterface::class)->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields);
    }

    public function referralEarning($referrerUserId, $referralUserId)
    {
        $searchFields = [
            ['stock_items.item', __('Stock Item')],
        ];

        $orderFields = [
            ['stock_items.item', __('Stock Item')],
            ['amount', __('Amount')],
        ];

        $where = [
            'referrer_user_id' => $referrerUserId,
            'referral_user_id' => $referralUserId,
        ];

        $select = [
            'stock_items.item',
            'stock_items.item_name',
            'stock_items.item_emoji',
            DB::raw('sum(amount) as amount')
        ];
        $joinArray = [
            ['stock_items', 'stock_items.id', '=', 'referral_earnings.stock_item_id'],
        ];

        $query = app(ReferralEarningInterface::class)->filters($searchFields, $orderFields, $where, $select, $joinArray, ['stock_items.item', 'stock_items.item_name', 'stock_items.item_emoji']);

        return app(DataListService::class)->dataList($query, $searchFields, $orderFields, false, false);
    }
}
