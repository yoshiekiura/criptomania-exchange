<?php

namespace App\Http\Controllers\User\Trader;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Trader\StockOrderRequest;
use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\StockOrderInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Trader\StockOrderService;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\User\StockOrder;

class OrdersController extends Controller
{
    private $stockOrderService;
    private $depositRepository;
    private $withdrawalRepository;
    private $stockOrderModel;

    public function __construct(DepositInterface $deposit, WithdrawalInterface $withdrawal, StockOrderService $stockOrderService, StockOrder $stockOrderModel)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->stockOrderService = $stockOrderService;
        $this->stockOrderModel = $stockOrderModel;
    }

    public function openOrdersJson()
    {
      $query = $this->stockOrderModel->join('stock_pairs', 'stock_pairs.id', '=', 'stock_orders.stock_pair_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_orders.user_id')->where('stock_orders.user_id', Auth::id())
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
                                ->addColumn('action',function($row){
                                     if(has_permission('trader.orders.destroy')){
                                        $destroy = '<a href='.route('trader.orders.destroy', $row->id).'
                                                       class="cancel-order">'.__('Cancel').'</a>';
                                        }

                                        return $destroy;

                                
                                })->setRowId('row')
                                ->rawColumns(['coin-pair','exchange_type','category','price','amount','total','email','stop-limit','action'])
                                ->make(true);

    }
    public function openOrders()
    {   
        $data['list'] = $this->stockOrderModel->join('stock_pairs', 'stock_pairs.id', '=', 'stock_orders.stock_pair_id')
                            ->join('stock_items', 'stock_items.id', '=', 'stock_pairs.stock_item_id')
                            ->join('stock_items as base_items', 'base_items.id', '=', 'stock_pairs.base_item_id')
                            ->join('users', 'users.id', '=', 'stock_orders.user_id')->where('stock_orders.user_id', Auth::id())
                            ->select([
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
        $data['title'] = __('Open Orders');

        return view('frontend.orders.open_orders', $data);
    }

    public function store(StockOrderRequest $request)
    {
        $response = app(StockOrderService::class)->order($request);

        if ($response[SERVICE_RESPONSE_STATUS]) {
            return response()->json([SERVICE_RESPONSE_SUCCESS => $response[SERVICE_RESPONSE_MESSAGE]]);
        }

        return response()->json([SERVICE_RESPONSE_ERROR => $response[SERVICE_RESPONSE_MESSAGE]]);

    }

    public function destroy(StockOrderInterface $stockOrderRepository, $id)
    {
        $stockOrder = $stockOrderRepository->getFirstById($id);
        // dd($stockOrder);
        if (empty($stockOrder)) {
            return response()->json([SERVICE_RESPONSE_ERROR => __('Order not found.')]);
        }


        if (Auth::id() != $stockOrder->user_id) {
            return response()->json([SERVICE_RESPONSE_ERROR => __('You are not authorize to do this action.')]);
        }

        if ($stockOrder->status >= STOCK_ORDER_COMPLETED) {
            return response()->json([SERVICE_RESPONSE_ERROR => __('This order cannot be deleted.')]);
        }


        $response = app(StockOrderService::class)->cancelOrder($id);
        if ($response[SERVICE_RESPONSE_STATUS]) {
            return response()->json([SERVICE_RESPONSE_SUCCESS => $response[SERVICE_RESPONSE_MESSAGE]]);
        }

        return response()->json([SERVICE_RESPONSE_ERROR => $response[SERVICE_RESPONSE_MESSAGE]]);
    }
}