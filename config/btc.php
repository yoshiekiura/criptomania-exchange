<?php

return [
    'scheme' => env('BTC_API_SCHEME', 'http'),
    'host' => env('BTC_API_HOST', '127.0.0.1'),
    'port' => env('BTC_API_PORT', 48210),
    'user' => env('BTC_API_RPCUSER','oWHMP'),
    'password' => env('BTC_API_RPCPASSWORD', 'inHopiGvYwiKU3S'),
    'network_fee' => env('BTC_API_NETWORK_FEE', 0.00001),
    'ca' => env('BTC_API_SSL_CERT'),
];