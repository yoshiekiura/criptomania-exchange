<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\BitcoinApi;
use App\Services\Api\CoinPaymentApi;
use App\Services\User\Trader\WalletService;
use Illuminate\Http\Request;

class IpnController extends Controller
{
    public function ipn(Request $request)
    {
        $ipnRequest = $request->all();
        // return $ipnRequest;
        if(env('APP_ENV') != 'production' && env('APP_DEBUG') == true) {
            logs()->info($ipnRequest);
        }

        if( empty($ipnRequest) || !isset($ipnRequest['currency']) )
        {
            logs()->error('log: Invalid coinpayment IPN request.');

            return response()->json('log: Invalid coinpayment IPN request.', 500);
        }

        $coinpayment = new CoinPaymentApi($ipnRequest['currency']);
        $ipnResponse = $coinpayment->validateIPN($ipnRequest, $request->server());

        
        if( $ipnResponse['error'] == 'ok')
        {
            app(WalletService::class)->updateTransaction($ipnResponse);

            return response()->json($ipnResponse, 200);

        }
        else
        {
            logs()->error($ipnResponse['error']);

            return response()->json($ipnResponse, 500);
        }
    }

    public function bitcoinIpn(Request $request, $currency)
    {
        try {
            $bitcoin = new BitcoinApi($currency);
            $listtr = $bitcoin->getListTransactions();
            foreach ($listtr as $list => $v ) {
                $obj = ['txn_id' => $v['txid']];
                
                $bitcoind = $bitcoin->validateIPN($obj, $request->server());
                

                if( $bitcoind['error'] == 'ok')
                {
                    app(WalletService::class)->updateTransaction($bitcoind);
                }
                else{
                    logs()->error($bitcoind['error']);

                    return null;
                }
            }
        }
        catch (\Exception $exception)
        {
            logs()->error( $exception->getMessage() );

            return null;
        }
    }
}