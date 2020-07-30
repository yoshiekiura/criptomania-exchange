<?php

namespace App\models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\DepositBankTransfer;

class ListBank extends Model
{
    protected $table = 'list_bank';
    protected $fillable = ['bank_name','account_number'];
    protected $primaryKey = 'id';

    public function belongsToDeposit()
    {
    	return $this->hasMany(DepositBankTransfer::class);
    }
}
