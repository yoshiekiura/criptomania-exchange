<?php
Route::group(['namespace' => 'User\Trader'], function () {
    Route::resource('upload-id', 'IdController')->only(['index', 'store'])->parameter('upload-id', 'id')->names('trader.upload-id');

    Route::get('wallets/{id}/deposit', 'WalletController@createDeposit')->name('trader.wallets.deposit');
    Route::post('wallets/{id}/deposit/store', 'WalletController@storeDeposit')->name('trader.wallets.deposit.store');
    Route::post('wallets/{id}/deposit/storeBank', 'WalletController@storeDepositWithBank')->name('trader.wallets.deposit.storeBank');
    Route::post('wallets/{id}/deposit/uploadStruck', 'WalletController@struckUpload')->name('trader.wallets.deposit.struckUpload');
    Route::get('wallets/{id}/invoice', 'WalletController@showInvoice')->name('trader.wallets.invoice');



    Route::get('wallets/{id}/withdrawal', 'WalletController@createWithdrawal')->name('trader.wallets.withdrawal');
    Route::post('wallets/{id}/withdrawal/store', 'WalletController@storeWithdrawal')->name('trader.wallets.withdrawal.store');
    Route::resource('wallets', 'WalletController')->only(['index'])->parameter('wallets', 'id')->names('trader.wallets');
    //wallet index json
    Route::get('wallets/json','WalletController@walletJsonIndex')->name('trader.wallets.json');

    Route::resource('orders', 'OrdersController')->only(['store', 'destroy'])->parameter('orders', 'id')->names('trader.orders');
    Route::delete('delete/order/{id}', 'OrdersController@destroy')->name('trader.order.delete');

    Route::get('my-open-orders', 'OrdersController@openOrders')->name('trader.orders.open-orders');
    Route::get('my-open-orders-json', 'OrdersController@openOrdersJson')->name('trader.orders.open-orders-json');
    Route::resource('questions', 'QuestionsController')->only(['index', 'create', 'store'])->parameter('questions', 'id')->names('trader.questions');
    Route::resource('trader-bank','BankNameController')->parameter('user_bank','id')->names('trader.trader-bank');
    Route::get('trader-bank-json','BankNameController@bankTraderJson')->name('trader.trader-bank.json');
    // Route::get('trader-bank', 'BankNameController@index')->name('trader.trader-bank.index');
    // Route::get('trader-bank/edit', 'BankNameController@edit')->name('trader.trader-bank.edit');
    // Route::put('trader-bank/update', 'BankNameController@update')->name('trader.trader-bank.update');
    // Route::put('trader-bank/delete', 'BankNameController@delete')->name('trader.trader-bank.delete');

    
});