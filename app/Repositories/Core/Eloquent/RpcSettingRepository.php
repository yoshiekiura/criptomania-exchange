<?php
/**
 * Created by PhpStorm.
 * User: zahid
 * Date: 2018-09-18
 * Time: 2:55 PM
 */

namespace App\Repositories\Core\Eloquent;

use App\Models\Core\Rpcport;
use App\Repositories\BaseRepository;
use App\Repositories\Core\Interfaces\RpcInterface;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;

class RpcSettingRepository extends BaseRepository implements RpcInterface
{
    /**
     * @var Rpc Setting
     */
    protected $model;

    public function __construct(Rpcport $model)
    {
        $this->model = $model;
    }

    public function getAllRpcPort()
    {
        $this->model->all();

    }

    public function getRpcCountByConditions(array $conditions)
    {
        return $this->model->where($conditions)->count();
    }

    public function updateRpcRows(array $attributes, array $conditions = null)
    {
        $model = is_null($conditions) ? $this->model : $this->model->where($conditions);

        return $model->update($attributes);
    }

    public function getRpcPort($conditions)
    {
        return $this->model->where($conditions)
            ->join('stock_items', 'stock_items.id', '=', 'rpc_port.stock_item_id')
            ->select([

                'rpc_port.*',
                'stock_items.item',
            ]);
    }

    public function listRpcJson()
    {
      $query = $this->model->join('stock_items','stock_items.id', '=','rpc_port.stock_item_id')
                           ->select([
                             'rpc_port.*',
                             'stock_items.item',
                           ])->get();
        return Datatables::of($query)
                          ->addIndexColumn()
                          ->addColumn('action',function($row){
                            $btn = '<div class="btn-group pull-right">
                                <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <ul class="dropdown-menu pull-right dropdown-menu-stock-pair">';


                              if(has_permission('rpcport.edit')){
                                        $btn .= '<li>
                                                      <a href="'.route('rpcport.edit', $row->id).'"><i
                                                                  class="fa fa-eye"></i>Edit</a>
                                                  </li>';
                              }


                                if(has_permission('rpcport.destroy')){
                                        $btn .=    '<li><a data-form-id="delete-'.$row->id.'" data-form-method="DELETE"
                                           href="'.route('rpcport.destroy', $row->id).'" class="confirmation"
                                           data-alert="'.__('Do you want to delete this RPC Port?').'"><i
                                                    class="fa fa-trash-o"></i>Delete</a></li>';
                                }

                        return $btn;
                      })->rawColumns(['action'])->make(true);
    }



}
