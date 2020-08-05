<?php

return [
    'scheme' => env('BTC_API_SCHEME', 'http'),
    'host' => env('BTC_API_HOST', '127.0.0.1'),
    'port' => env('BTC_API_PORT', 8332),
    'user' => env('BTC_API_RPCUSER','test'),
    'password' => env('BTC_API_RPCPASSWORD', 'test'),
    'network_fee' => env('BTC_API_NETWORK_FEE', 0.00001),
    'ca' => env('BTC_API_SSL_CERT'),
];