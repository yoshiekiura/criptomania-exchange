<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\models\backend\ListBank;
use  App\Models\Backend\StockItem;
use App\Models\User\Wallet;
use App\Models\Backend\Transaction;
class DepositBankTransfer extends Model
{
    protected $table = 'deposit_bank_transfer';
    protected $fillable = ['ref_id','users_id','wallet_id','stock_item_id','admin_bank_id','amount','network_fee','system_fee','status','payment_prove','created_at','updated_at',];
    protected $primaryKey = 'id';

    public function manyToBankAdmin()
    {
    	return $this->hasMany(ListBank::class);
    }

    public function manyToUser()
    {
    	return $this->hasMany(User::class);
    }

    public function manyToStockItemId()
    {
        return $this->hasMany(StockItem::class);
    }

    public function manyToWallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function toTranscation()
    {
        return $this->belongsTo(Transaction::class);
    }
}
