<?php

namespace App\Models\Backend;
use App\Models\User\DepositBankTransfer;
use App\Models\Backend\StockItem;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'transactions';
	protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'stock_item_id', 'model_name', 'model_id','deposit_bank_id', 'transaction_type', 'journal', 'amount'];

    public function oneToDepositBankTransfer()
    {
    	return $this->hasOne(DepositBankTransfer::class);
    }

    public function manyToStockItemId()
    {
    	return $this->hasMany(StockItem::class);
    }
}