<?php

namespace App\Models\Backend;
use App\Models\User\DepositBankTransfer;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'stock_item_id', 'table_name', 'row_id', 'transaction_type', 'amount'];

    public function oneToDepositBankTransfer()
    {
    	return $this->hasOne(DepositBankTransfer::class);
    }
}