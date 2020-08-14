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
   
}