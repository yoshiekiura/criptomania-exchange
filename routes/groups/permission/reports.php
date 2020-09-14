<?php
Route::group(['namespace' => 'Reports\Admin'], function () {
    Route::group(['prefix' => 'reports'], function () {
        Route::get('deposits/{paymentTransactionType?}', 'ReportsController@allDeposits')->name('reports.admin.all-deposits');
        Route::get('depositsJson/{paymentTransactionType?}', 'ReportsController@depositTraderJson')->name('reports.admin.all-deposits.json'); //report admin all deposit trader Json
        Route::get('depositsBank/{paymentTransactionType?}', 'ReportsController@allDepositsBank')->name('reports.admin.all-deposits-bank');
        Route::get('depositsBankJson/{paymentTransactionType?}', 'ReportsController@depositBankTraderJson')->name('reports.admin.all-deposits-bank.json');
        Route::get('withdrawals/{paymentTransactionType?}', 'ReportsController@allWithdrawals')->name('reports.admin.all-withdrawals');
        Route::get('withdrawalsJson/{paymentTransactionType?}', 'ReportsController@withdrawalsTraderJson')->name('reports.admin.all-withdrawals.json');
        Route::get('trades/{categoryType?}', 'ReportsController@allTrades')->name('reports.admin.allTrades');
        Route::get('trades/{userId}/{categoryType?}', 'ReportsController@trades')->name('reports.admin.trades');
        Route::get('tradesJson/{userId?}/{categoryType?}', 'ReportsController@tradesJson')->name('reports.admin.trades.json');
        Route::get('coins-pairs/{id}/trades', 'ReportsController@tradesByStockPairId')->name('reports.admin.stock-pairs.trades');
        Route::get('coins-pairs-json/{id}/trades', 'ReportsController@stockPairTraderJson')->name('reports.admin.stock-pairs.json');
        Route::get('open-orders/{userId?}', 'ReportsController@openOrders')->name('reports.admin.open-orders');
        Route::get('open-orders-json/{userId?}', 'ReportsController@openOrdersJson')->name('reports.admin.open-orders.json');
        Route::get('coins-pairs/{id}/open-orders', 'ReportsController@openOrdersByStockPairId')->name('reports.admin.stock-pairs.open-orders');
        Route::get('coins-pairs/{id}/stock-pair-open-orders-json', 'ReportsController@openOrdersStockPairJson')->name('reports.admin.stock-pairs-id.open-orders');

        Route::get('transactionsJson/{id?}/{journalType?}', 'TransactionController@generateTransaction')->name('reports.admin.transaction.user.json');
        Route::get('transactions/{journalType?}', 'TransactionController@allUser')->name('reports.admin.transaction.all-users');
        Route::get('transactions/{id}/{journalType?}', 'TransactionController@user')->name('reports.admin.transaction.user');
    });

    Route::get('wallets/{id}/deposits/{paymentTransactionType?}', 'ReportsController@deposits')->name('reports.admin.wallets.deposits');

    //report admin trader deposit json with wallet id
    Route::get('walletsJson/{walletId?}/deposits/{paymentTransactionType?}', 'ReportsController@depositTraderJson')->name('reports.admin.wallets.deposit.json');
    //report admin trader withdraw json with wallet id
    Route::get('withdrawalsJson/{walletId?}/withdrawal/{paymentTransactionType?}', 'ReportsController@withdrawalsTraderJson')->name('reports.admin.withdrawals.json');
    //report admin trader depositBank json with wallet id
    Route::get('walletsBankJson/{walletId?}/deposits/{paymentTransactionType?}', 'ReportsController@depositBankTraderJson')->name('reports.admin.deposits-bank.json');



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
    //report trader all deposit
    Route::get('depositsJson', 'ReportsController@allDepositTraderJson')->name('reports.trader.alldeposits.json');
    //report trader deposit json with wallet id
    Route::get('walletsJsonTrader/{walletId?}/deposits/{paymentTransactionType?}', 'ReportsController@depositTraderJson')->name('reports.trader.deposits.json');
    //report trader withdraw json with wallet id
    Route::get('walletJsonTrader/{id}/withdrawals/{paymentTransactionType?}', 'ReportsController@withdrawalsTraderWalletJson')->name('reports.trader.withdrawals.json');
    //report trader depositBank json with wallet id
    Route::get('wallet-bankTraderJson/{id}/depositsBank-Trader/{paymentTransactionType?}', 'ReportsController@depositBankTraderJson')->name('reports.trader.deposits-bank.json');



    //report trader all withdrawals
    Route::get('withdrawalsJson', 'ReportsController@withdrawalsTraderJson')->name('reports.trader.all-withdrawals.json');
    Route::get('withdrawals/{paymentTransactionType?}', 'ReportsController@allWithdrawals')->name('reports.trader.all-withdrawals');
    Route::get('wallet/{id}/withdrawals/{paymentTransactionType?}', 'ReportsController@withdrawals')->name('reports.trader.withdrawals');
    Route::get('my-trades/{categoryType?}', 'ReportsController@trades')->name('reports.trader.trades');
    //my trades Json
    Route::get('my-trades-json/{categoryType?}', 'ReportsController@tradesJson')->name('reports.trader.trades.json');
    //referral json
    Route::get('my-referral-users-json', 'ReportsController@referralUsersJson')->name('reports.trader.referral.json');
    Route::get('my-referral-users', 'ReportsController@referralUsers')->name('reports.trader.referral');
    Route::get('my-referral-users/referral-earning', 'ReportsController@referralEarning')->name('reports.trader.referral-earning');
});
