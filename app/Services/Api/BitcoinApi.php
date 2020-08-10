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

            'scheme' => 'http',
            'host' => '127.0.0.1',
            'port' => 48210,
            'user' => 'uus',
            'password' => 'daus',
            'network_fee' => null,
            'ca' => null,

        ]);
    }
}