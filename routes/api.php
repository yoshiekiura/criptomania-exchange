<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('/ipn', 'Api\IpnController@ipn')->name('ipn.api');
Route::any('/bitcoin/ipn/{currency}', 'Api\IpnController@bitcoinIpn')->name('ipn.btc.api');
Route::get('/public', 'Api\PublicApiController@command');
Route::get('/api-stockItem','Api\ApiStockItemController@showApiName')->name('api.stockItem');
