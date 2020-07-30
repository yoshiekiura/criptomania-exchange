<?php

namespace App\Http\Controllers\Reports\Admin;

use App\Repositories\User\Trader\Interfaces\DepositInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Admin\ReportsService;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    private $reportsService;
    private $depositRepository;
    private $withdrawalRepository;
    private $depoBankRepo;

    public function __construct(DepositInterface $deposit, WithdrawalInterface $withdrawal, ReportsService $reportsService, DepositBankInterface $depoBank)
    {
        $this->depositRepository = $deposit;
        $this->withdrawalRepository = $withdrawal;
        $this->reportsService = $reportsService;
        $this->depoBankRepo = $depoBank;
    }

    public function allDeposits($paymentTransactionType = null)
    {
        $data['list'] = $this->reportsService->deposits(null, null, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit', $data);
    }

    public function deposits($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->deposits(null, $id, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.deposit', $data);
    }

     public function editBankDepoStatus($id)
    {
        $data['title'] = __('Edit Status');
        $data['list'] = $this->depoBankRepo->findOrFailById($id);

        return view('backend.reports.changeStatus', $data);
    }

    public function allDepositsBank($paymentTransactionType = null)
    {
        $data['list'] = $this->reportsService->depositBankTransfer(null, null, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_deposit_bank', $data);
    }

    public function depositsBank($id, $paymentTransactionType = null)
    {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->depositBankTransfer(null, $id, $paymentTransactionType);
        $data['title'] = __('Deposits');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.deposit_bank', $data);
    }

    public function allWithdrawals($paymentTransactionType = null) {
        $data['list'] = $this->reportsService->withdrawals(null, null, $paymentTransactionType);
        $data['title'] = __('Withdrawals');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.all_withdrawal', $data);
    }

    public function withdrawals($id, $paymentTransactionType = null) {
        $data['wallet'] = app(WalletInterface::class)->firstOrFail(['id' => $id], 'stockItem');
        $data['list'] = $this->reportsService->withdrawals(null, $id, $paymentTransactionType);
        $data['title'] = __('Withdrawals');
        $data['status'] = $paymentTransactionType;

        return view('backend.reports.withdrawal', $data);
    }

    public function allTrades($categoryType = null) {
        $data['list'] = $this->reportsService->trades(null, $categoryType);
        $data['title'] = __('Trades');
        $data['categoryType'] = $categoryType;

        return view('backend.reports.trades', $data);
    }

    public function trades($userId, $categoryType = null) {
        $data['list'] = $this->reportsService->trades($userId, $categoryType);
        $data['title'] = __('Trades');
        $data['categoryType'] = $categoryType;

        return view('backend.reports.trades', $data);
    }

    public function openOrders($userId)
    {
        $data['list'] = $this->reportsService->openOrders($userId);
        $data['title'] = __('Open Orders');
        $data['hideUser'] = $userId;

        return view('backend.reports.open_orders', $data);
    }

    public function tradesByStockPairId($id, $categoryType = null) {
        $data['list'] = $this->reportsService->trades(null, $categoryType, $id);
        $data['title'] = __('Trades');
        $data['categoryType'] = $categoryType;

        return view('backend.reports.trades', $data);
    }

    public function openOrdersByStockPairId($id)
    {
        $data['list'] = $this->reportsService->openOrders(null, null, $id);
        $data['title'] = __('Open Orders');
        $data['hideUser'] = false;

        return view('backend.reports.open_orders', $data);
    }
}