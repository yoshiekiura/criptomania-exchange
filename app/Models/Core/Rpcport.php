<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\StockItem;

/*
	Developer   : Muhammad Rizky Firdaus
	Date        : 11-08-2020
	Description : Model RPC Port for stock item api service
*/

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
    	'cert_ca',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'id';


    public function toStockItemId()
    {
    	return $this->hasMany(StockItem::class);
    }
}
