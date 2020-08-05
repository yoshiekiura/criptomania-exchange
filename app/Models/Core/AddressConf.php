<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class AddressConf extends Model
{
    protected $table = 'address_cryp';
    protected $fillable = ['currency_name', 'scheme', 'host', 'port', 'rpcuser','rpcpassword','network_fee','ssl_cert'];
    protected $primaryKey = 'id';


}
