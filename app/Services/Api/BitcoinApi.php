<?php


namespace App\Services\Api;


use Denpa\Bitcoin\Client as BitcoinClient;
use App\Models\Core\Rpcport;
use App\Models\Backend\StockItem;
use App\Models\User\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\Trader\Interfaces\WalletInterface;


class BitcoinApi extends Bitcoind
{

    protected $bitcoind;
    protected $currency;
    protected $networkFee;

    /*
        Modified by : Muhammad Rizky Firdaus
        Date        : 11-08-2020
        Description : Make API for cryptocurrency coin to getnewaddress, deposit, get_tx_ids, etc
    */

    public function __construct($currency)
    {

        $this->currency = $currency;

        $stock_item = StockItem::select('id')->where('item',$this->currency)->first();

        $rpc = Rpcport::select('scheme','host','port','rpc_user','rpc_password','network_fee','cert_ca')
               ->where('stock_item_id' ,'=', $stock_item->id)
               ->first();


        $this->bitcoind = new BitcoinClient([    
            'scheme' => $rpc->scheme,
            'host' => $rpc->host,
            'port' => $rpc->port,
            'user' => $rpc->rpc_user,
            'password' => $rpc->rpc_password,
            'network_fee' => $rpc->network_fee,
            'ca' => $rpc->cert_ca,
        ]);
        // [

            // 'scheme' => $rpc->scheme,
            // 'host' => $rpc->host,
            // 'port' => $rpc->port,
            // 'user' => $rpc->rpc_user,
            // 'password' => $rpc->rpc_password,
            // 'network_fee' => $rpc->network_fee,
            // 'ca' => $rpc->cert_ca,

        // ]);
    }
}