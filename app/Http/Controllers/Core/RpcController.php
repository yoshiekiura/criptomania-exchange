<?php

namespace App\Http\Controllers\Core;

// use Illuminate\Http\Request;
use App\Http\Requests\Core\RpcRequest;
use App\Http\Controllers\Controller;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Core\Interfaces\RpcInterface;
use App\Repositories\User\Admin\Interfaces\StockItemInterface;


class RpcController extends Controller
{
	protected $rpcrepository;

    public function __construct(RpcInterface $rpcrepository){

    	$this->rpcrepository = $rpcrepository;
    }

    public function index(){

 		$searchFields = [
            ['stock_items.item', __('Coin Name')],
            ['port', __('Port Number')],
        ];

        $orderFields = [
            ['stock_items.item', __('Coin Name')],
            ['port', __('Port Number')],
        ];

        $joinArray = ['stock_items', 'stock_items.id', '=', 'rpc_port.stock_item_id'];
        $select = ['rpc_port.*','stock_items.item'];

        $query = $this->rpcrepository->paginateWithFilters($searchFields, $orderFields,null, $select, $joinArray);
        $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        $data['title'] = __('List RPC Port API');

        return view('backend.rpcport.index', $data);

 	}

 	 public function create(){

        $data['stockItems'] = app(StockItemInterface::class)->getActiveList()->pluck('item', 'id')->toArray();
        $data['title'] = __('Create New Port');

        return view('backend.rpcport.create', $data);

    }

    public function store(RpcRequest $request)
    {
        $rpcInput = $request->all();
        $rpc = $this->rpcrepository->create($rpcInput);

        if (!empty($rpc)) {
            return redirect()->route('rpcport.index')->with(SERVICE_RESPONSE_SUCCESS, __('RPC has been created successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create RPC.'));
    }

    public function edit($id){


        $data['rpcPort'] = $this->rpcrepository->findOrFailById($id);
        $data['stockItems'] = app(StockItemInterface::class)->getActiveList()->pluck('item', 'id')->toArray();
        $data['title'] = __('Edit RPC Port');

        return view('backend.rpcport.edit', $data);

    }

     public function update(RpcRequest $request, $id)
    {
        $rpcAttr = $request->all();

        if ($this->rpcrepository->update($rpcAttr, $id)) {
            return redirect()->route('rpcport.index')->with(SERVICE_RESPONSE_SUCCESS, __('RPC Port has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to update RPC Port.'));
    }

    public function destroy($id)
    {
        if ( $this->rpcrepository->deleteById($id)) {
            return redirect()->route('rpcport.index')->with(SERVICE_RESPONSE_SUCCESS, __('RPC has been deleted successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete RPC Port.'));
    }
}
