<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\StockItem;

class ApiService extends Model
{
    protected $table = 'api_stock_item';
    protected $fillable = ['api_name','api_value','created_at','updated_at'];
    protected $primaryKey = 'id';

    public function toStockItem()
    {
    	return $this->hasMany(StockItem::class);
    }

}
