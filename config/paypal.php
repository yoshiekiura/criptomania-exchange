<?php
return [
    'client_id' => env('PAYPAL_CLIENT_ID', ''),
    'secret' => env('PAYPAL_SECRET', ''),
    'intent' => env('PAYPAL_INTENT', ''),
    'return_url' => env('RETURN_URL', ''),
    'cancel_url' => env('CANCEL_URL', ''),
    'settings' => array(
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];