<?php
Route::group(['namespace' => 'Reports\Admin'], function () {
    Route::group(['prefix' => 'reports'], function () {
        Route::get('deposits/{paymentTransactionType?}', 'ReportsController@allDeposits')->name('reports.admin.all-deposits');
        Route::get('depositsBank/{paymentTransactionType?}', 'ReportsController@allDepositsBank')->name('reports.admin.all-deposits-bank');
        Route::get('withdrawals/{paymentTransactionType?}', 'ReportsController@allWithdrawals')->name('reports.admin.all-withdrawals');
        Route::get('trades/{categoryType?}', 'ReportsController@allTrades')->name('reports.admin.allTrades');
        Route::get('trades/{userId}/{categoryType?}', 'ReportsController@trades')->name('reports.admin.trades');
        Route::get('coins-pairs/{id}/trades/{categoryType?}', 'ReportsController@trades')->name('reports.admin.stock-pairs.trades');
        Route::get('open-orders/{userId}', 'ReportsController@openOrders')->name('reports.admin.open-orders');
        Route::get('coins-pairs/{id}/open-orders', 'ReportsController@openOrdersByStockPairId')->name('reports.admin.stock-pairs.open-orders');
        Route::get('transactions/{journalType?}', 'TransactionController@allUser')->name('reports.admin.transaction.all-users');
        Route::get('transactions/{id}/{journalType?}', 'TransactionController@user')->name('reports.admin.transaction.user');
    });

    Route::get('wallets/{id}/deposits/{paymentTransactionType?}', 'ReportsController@deposits')->name('reports.admin.wallets.deposits');
    
    // ini untuk admin
    Route::get('wallets-bankAdmin/{id}/depositsBank-admin/{paymentTransactionType?}', 'ReportsController@depositsBank')->name('reports.admin.wallets.depositsBank');

    Route::get('wallets/{id}/withdrawals/{paymentTransactionType?}', 'ReportsController@withdrawals')->name('reports.admin.wallets.withdrawals');
    Route::get('wallets/{id}/changeStatus', 'ReportsController@editBankDepoStatus')->name('change.status.bankDepo');
});

Route::group(['namespace' => 'Reports\Trader'], function () {
    Route::get('deposits/{paymentTransactionType?}', 'ReportsController@allDeposits')->name('reports.trader.all-deposits');
    Route::get('depositsTraderBank/{paymentTransactionType?}', 'ReportsController@allDepositsBank')->name('reports.trader.all-deposits-bank');
    Route::get('wallet/{id}/deposits/{paymentTransactionType?}', 'ReportsController@deposits')->name('reports.trader.deposits');

    // ini untuk trader
    Route::get('wallet-bankTrader/{id}/depositsBank-Trader/{paymentTransactionType?}', 'ReportsController@depositsBank')->name('reports.trader.deposits-bank');

    Route::get('withdrawals/{paymentTransactionType?}', 'ReportsController@allWithdrawals')->name('reports.trader.all-withdrawals');
    Route::get('wallet/{id}/withdrawals/{paymentTransactionType?}', 'ReportsController@withdrawals')->name('reports.trader.withdrawals');
    Route::get('my-trades/{categoryType?}', 'ReportsController@trades')->name('reports.trader.trades');
    Route::get('my-referral-users', 'ReportsController@referralUsers')->name('reports.trader.referral');
    Route::get('my-referral-users/referral-earning', 'ReportsController@referralEarning')->name('reports.trader.referral-earning');
});