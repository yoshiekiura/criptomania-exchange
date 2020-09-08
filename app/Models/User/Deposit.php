<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\StockItem;
use App\Models\User\User;

class Deposit extends Model
{
	protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'ref_id', 'wallet_id', 'stock_item_id', 'amount', 'network_fee', 'system_fee', 'address', 'txn_id', 'payment_method','bank_name', 'status'];

    public function depositBank()
    {
    	return $this->belongsToMany(DepositBankTransfer::class);
    }

    public function stockItem(){
    	return $this->hasMany(StockItem::class);
    }

    public function userJoin(){
    	return $this->hasMany(User::class);
    }
}
