<?php

namespace App\Http\Controllers\Reports\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\User\Admin\Interfaces\TransactionInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\Transaction;
use DataTables;


class TransactionController extends Controller
{
    private $transactionModel;

    public function __construct(Transaction $transactionModel)
    {
        $this->transactionModel = $transactionModel;
    }
    public function user($userId, $journalType = null)
    {

        // $data = $this->generateTransaction($userId, $journalType);
        $data['title'] = __('Transaction');
        $data['journalType'] = $journalType;
        $data['userId'] = $userId;
        $data['summary'] = DB::table('transactions')->join('stock_items', 'stock_items.id', '=', 'transactions.stock_item_id')
                                         ->join('users', 'users.id', '=', 'transactions.user_id')
                                         ->join('user_infos', 'users.id', '=', 'user_infos.user_id');
                                         if (!is_null($userId)) {
                                            // $where['transactions.user_id'] = $userId;
                                            $query->where('transactions.user_id', $userId);
                                         }

                                         if (!is_null($journalType)) {
                                             // $where['journal'] = config('commonconfig.journal_type.' . $journalType);
                                             $query->where('journal',config('commonconfig.journal_type.' . $journalType));
                                         }
                $data = $query->select([
                    'transactions.transaction_type',
                    'stock_items.item', 'journal', DB::raw('sum(amount) as amount')
                ])->groupBy('stock_items.item', 'journal','transactions.transaction_type')->get();

        return view('backend.transactions.all_users', $data);
    }

    public function generateTransaction($userId = null, $journalType = null)
    {
        // $searchFields = [
        //     ['first_name', __('First Name')],
        //     ['last_name', __('Last Name')],
        //     ['email', __('Email')],
        //     ['item', __('Stock Item')],
        // ];


        // $orderFields = [
        //     ['amount', __('Amount')],
        //     ['transactions.created_at', __('Date')],
        // ];


        // $where = null;

        // if (!is_null($userId)) {
        //     $where['transactions.user_id'] = $userId;
        // }

        // if (!is_null($journalType)) {
        //     $where['journal'] = config('commonconfig.journal_type.' . $journalType);
        // }

        // $select = ['transactions.*', 'first_name', 'last_name', 'email', 'item'];
        // $joinArray = [
        //     ['stock_items', 'stock_items.id', '=', 'transactions.stock_item_id'],
        //     ['users', 'users.id', '=', 'transactions.user_id'],
        //     ['user_infos', 'users.id', '=', 'user_infos.user_id'],
        // ];

        // $query = app(TransactionInterface::class)->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);
        // $select = ['stock_items.item', 'journal', DB::raw('sum(amount) as amount')];
        // $data['summary'] = app(TransactionInterface::class)->filters($searchFields, $orderFields, $where, $select, $joinArray, ['stock_items.item', 'journal']);
        // $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        // return $data;

        $query = $this->transactionModel->join('stock_items', 'stock_items.id', '=', 'transactions.stock_item_id')
                                         ->join('users', 'users.id', '=', 'transactions.user_id')
                                         ->join('user_infos', 'users.id', '=', 'user_infos.user_id');
                                         if (!is_null($userId)) {
                                            // $where['transactions.user_id'] = $userId;
                                            $query->where('transactions.user_id', $userId);
                                         }

                                         if (!is_null($journalType)) {
                                             // $where['journal'] = config('commonconfig.journal_type.' . $journalType);
                                             $query->where('journal',config('commonconfig.journal_type.' . $journalType));
                                         }
                $data = $query->select([
                    'transactions.*', 
                    'first_name', 
                    'last_name', 
                    'email',
                    'item',
                ])->get();

                return Datatables::of($data)
                                    ->addIndexColumn()
                                    ->editColumn('email',function($user){
                                        if(has_permission('users.show')){
                                            $show ='<a href='.route('users.show', $user->user_id).'>'.$user->email.'</a>';
                                        }
                                        else{
                                            $show = $transaction->email;
                                        }
                                        return $show;
                                       
                                    })
                                    ->editColumn('transactions-type',function($transaction){
                                        return get_transaction_type($transaction->transaction_type);
                                    })
                                    ->editColumn('journal-type',function($transaction){
                                        $journal = array_flip(config('commonconfig.journal_type'))[$transaction->journal];
                                        $span = '<span>'.title_case(str_replace('-',' ',$journal)).'</span>';

                                        return $span;
                                    })->rawColumns(['email','transactions-type','journal-type'])->make(true);


    }

    public function generateSumTransaction($userId = null, $journalType = null)
    {
        // $searchFields = [
        //     ['first_name', __('First Name')],
        //     ['last_name', __('Last Name')],
        //     ['email', __('Email')],
        //     ['item', __('Stock Item')],
        // ];


        // $orderFields = [
        //     ['amount', __('Amount')],
        //     ['transactions.created_at', __('Date')],
        // ];


        // $where = null;

        // if (!is_null($userId)) {
        //     $where['transactions.user_id'] = $userId;
        // }

        // if (!is_null($journalType)) {
        //     $where['journal'] = config('commonconfig.journal_type.' . $journalType);
        // }

        // $select = ['transactions.*', 'first_name', 'last_name', 'email', 'item'];
        // $joinArray = [
        //     ['stock_items', 'stock_items.id', '=', 'transactions.stock_item_id'],
        //     ['users', 'users.id', '=', 'transactions.user_id'],
        //     ['user_infos', 'users.id', '=', 'user_infos.user_id'],
        // ];

        // $query = app(TransactionInterface::class)->paginateWithFilters($searchFields, $orderFields, $where, $select, $joinArray);
        // $select = ['stock_items.item', 'journal', DB::raw('sum(amount) as amount')];
        // $data['summary'] = app(TransactionInterface::class)->filters($searchFields, $orderFields, $where, $select, $joinArray, ['stock_items.item', 'journal']);
        // $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        // return $data;

        $query = DB::table('transactions')->join('stock_items', 'stock_items.id', '=', 'transactions.stock_item_id')
                                         ->join('users', 'users.id', '=', 'transactions.user_id')
                                         ->join('user_infos', 'users.id', '=', 'user_infos.user_id');
                                         if (!is_null($userId)) {
                                            // $where['transactions.user_id'] = $userId;
                                            $query->where('transactions.user_id', $userId);
                                         }

                                         if (!is_null($journalType)) {
                                             // $where['journal'] = config('commonconfig.journal_type.' . $journalType);
                                             $query->where('journal',config('commonconfig.journal_type.' . $journalType));
                                         }
                $data = $query->select([
                    'transactions.transaction_type',
                    'stock_items.item', 'journal', DB::raw('sum(amount) as amount')
                ])->groupBy('stock_items.item', 'journal','transactions.transaction_type')->get();

                return Datatables::of($data)
                                   ->addIndexColumn()
                                   ->editColumn('transaction-type', function($transaction){
                                        $journal = array_flip(config('commonconfig.journal_type'));
                                        $data = '<strong>'.title_case(str_replace('-',' ',$journal[$transaction->transaction_type])).'</strong>';

                                        return $data;

                                   })
                                   ->editColumn('amount', function($transaction){
                                        $data = $transaction->amount;

                                        return $data;
                                   })->rawColumns(['transaction-type', 'amount'])->make(true);


    }

    public function allUser($userId = null, $journalType = null)
    {

        $data['title'] = __('Transaction');
        $data['journalType'] = $journalType;
       // dd($data['summary']->groupBy(['item','transaction_type']));

        $query = DB::table('transactions')->join('stock_items', 'stock_items.id', '=', 'transactions.stock_item_id')
                                         ->join('users', 'users.id', '=', 'transactions.user_id')
                                         ->join('user_infos', 'users.id', '=', 'user_infos.user_id');
                                         if (!is_null($userId)) {
                                            // $where['transactions.user_id'] = $userId;
                                            $query->where('transactions.user_id', $userId);
                                         }

                                         if (!is_null($journalType)) {
                                             // $where['journal'] = config('commonconfig.journal_type.' . $journalType);
                                             $query->where('journal',config('commonconfig.journal_type.' . $journalType));
                                         }
                $data['summary'] = $query->select([
                    'transactions.transaction_type',
                    'stock_items.item', 'journal', DB::raw('sum(amount) as amount')
                ])->groupBy('stock_items.item', 'journal','transactions.transaction_type')->get();
         
        return view('backend.transactions.all_users', $data);
    }
}
