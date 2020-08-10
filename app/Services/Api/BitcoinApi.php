<?php


namespace App\Services\Api;


use Denpa\Bitcoin\Client as BitcoinClient;

class BitcoinApi extends Bitcoind
{

    protected $bitcoind;
    protected $currency;
    protected $networkFee;

    public function __construct($currency)
    {
        $this->currency = $currency;
        $configuration = config(strtolower($currency));

    

        $this->bitcoind = new BitcoinClient([

            'scheme' => env('BTC_API_SCHEME', 'http'),
            'host' => env('BTC_API_HOST', '127.0.0.1'),
            'port' => env('BTC_API_PORT', 48210),
            'user' => env('BTC_API_RPCUSER','daus'),
            'password' => env('BTC_API_RPCPASSWORD', 'user'),
            'network_fee' => env('BTC_API_NETWORK_FEE', 0.00001),
            'ca' => env('BTC_API_SSL_CERT'),

        ]);
    }
}