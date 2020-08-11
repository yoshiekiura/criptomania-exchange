<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\StockItem;

class Rpcport extends Model
{
    protected $table = 'rpc_port';
    protected $fillable = [

    	'stock_item_id',
    	'scheme',
    	'host',
    	'port',
    	'rpc_user',
    	'rpc_password',
    	'network_fee',
    	'cert_ca'
    ];

    protected $primaryKey = 'id';


    public function toStockItemId()
    {
    	return $this->hasMany(StockItem::class);
    }
}
