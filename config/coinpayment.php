<?php

return [
    'private_key' => env('COINPAYMENT_PRIVATE_KEY', '8db639173A2dbe2815ad54d6efD1c2B585Ba9602684131797eb5Cc5354A6961D'),
    'public_key' => env('COINPAYMENT_PUBLIC_KEY', 'd86b80666101d8c0e0d1ac7c95878406d810358bf33ea5d6ea814f42e0508284'),
    'merchant_id' => env('COINPAYMENT_MERCHANT_ID', '8aab2126443bc83099290a56a63bb1f7'),
    'ipn_secret' => env('COINPAYMENT_IPN_SECRET', 'testter'),
    'ipn_url' => env('COINPAYMENT_IPN_URL', 'http://homestead.test/api/ipn'),
    'ch' => env('COINPAYMENT_CH', null),
];