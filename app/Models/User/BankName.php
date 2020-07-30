<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class BankName extends Model
{
    protected $table = 'user_bank';
    protected $fillable = ['user_id','bank_name','account_number'];

    public function userId()
    {
        return $this->belongsTo(User::class);

    }
}
