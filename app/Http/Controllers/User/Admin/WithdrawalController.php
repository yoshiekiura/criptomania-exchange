<?php

namespace App\Http\Controllers\User\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ReversWithdrawal;
use App\Http\Requests\User\Admin\UpdateWalletBalanceRequest;
use App\Jobs\StockItemWithdrawal;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Admin\ReportsService;
use App\Models\User\Withdrawal;
use App\Repositories\User\Admin\Interfaces\TransactionInterface;
use App\Repositories\User\Interfaces\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User\Wallet;
use App\Models\Backend\StockItem;



class WithdrawalController extends Controller
{
    private $withdrawalRepository;

    public function __construct(WithdrawalInterface $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function withdrawalsBankTransferJson()
    {
      return app(ReportsService::class)->withdrawalsBankTransfer();
    }

    public function withdrawalCryptoCurrencyJson()
    {
      return $this->withdrawalRepository->withdrawalCryptoCurrency();
    }

    public function index()
    {
        // $transactionType = PAYMENT_REVIEWING;
        // $data['list'] = app(ReportsService::class)->withdrawals(null, null, null);
        // $data['title'] = __('Withdrawals for Reviewing');
        $data['cryptoCurrency'] = StockItem::where('item_type',CURRENCY_CRYPTO)
                                            ->select(['item'])->get();
        $data['realCurrency'] = StockItem::where('item_type',CURRENCY_REAL)
                                            ->select(['item'])->get();

        return view('backend.review_withdrawals.withdrawal',$data);
    }

    public function show($id)
    {

        $data['title'] = __('Review Withdrawal');
        $data['withdrawal'] = $this->withdrawalRepository->findOrfailById($id, ['stockItem', 'wallet', 'user', 'user.userinfo']);
        $data['user'] = $data['withdrawal']->user;
        // $data['userBank'] = ;

        return view('backend.review_withdrawals.show', $data);
    }

    public function approve($id)
    {
        $attributes = ['status' => PAYMENT_PENDING];
        $conditions = [ 'id' => $id, 'status' => PAYMENT_REVIEWING ];

        if( $this->withdrawalRepository->updateByConditions($attributes, $conditions) )
        {
            dispatch( new StockItemWithdrawal($id) );

            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The withdrawal has been approved successfully.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Invalid Request.'));
    }

    public function decline($id)
    {
        $attributes = ['status' => PAYMENT_DECLINED];
        $conditions = [ 'id' => $id, 'status' => PAYMENT_REVIEWING ];

        if( $this->withdrawalRepository->updateByConditions($attributes, $conditions) )
        {
            dispatch(new ReversWithdrawal($id));

            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The withdrawal has been declined successfully.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Invalid Request.'));
    }



    /*


        Doc Code : 1
        Developer : Daus
        Date : 23/07/2020
        Description : Method decline Bank dan approve Bank digunakan untuk menolak atau menerima request withdraw dari trader.
                      Fungsi ini hanya akan dijalankan dengan kondisi dimana payment_method dari withdraw adalah BANK_TRANSFER atau 4.
        NOTE : (JIKA TERJADI BUG SAAT WITHDRAW DENGAN TIPE TRANSAKSI SELAIN BANK TRANSFER. LIHAT KEMBALI FUNGSI INI!)



    */

     public function declineBank(Request $request, $id)
    {
       $attributes = ['primary_balance' => DB::raw('primary_balance + ' . $request->amount)];

        try {
            DB::beginTransaction();

            $withdrawalRepository = app(WithdrawalInterface::class);

            // get the wallet
            $withdrawal = $withdrawalRepository->getFirstByConditions(['id' => $id, 'status' => PAYMENT_REVIEWING], ['stockItem','wallet']);

            // if wallet not found or user has been deleted from admin then the wallet is deleted to

            if (empty($withdrawal)) {
                throw new \Exception(__('No wallet is found.'));
            }



            $date = now();
            // parameter untuk transaksi table
            $transactionParameters = [
                [
                    'user_id' => $withdrawal->user_id,
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($withdrawal->wallet),
                    'model_id' => $withdrawal->wallet->id,
                    'transaction_type' => TRANSACTION_TYPE_TRANSFER,
                    'amount' => $withdrawal->amount,
                    'journal' => INCREASED_TO_WALLET_ON_WITHDRAWAL_CANCELLATION, //menambahkan ke wallet user dari withdraw yang ditolak
                    'updated_at' => $date,
                    'created_at' => $date,
                ]
            ];

            $withdrawStatusAtr = [

                    'status' => PAYMENT_DECLINED,
            ];

            $walletAmmount = [
                'primary_balance' => DB::raw('primary_balance + ' . $withdrawal->amount),
            ];


            $notificationParameter = [
                'user_id' => $withdrawal->user_id,
                'data' => __("Your Withdrawal Has Been Declined and Your :currency wallet has been increased with :amount :currency by system.", [
                    'amount' => $request->amount,
                    'currency' => $withdrawal->stockItem->item
                ]),
            ];

            // Query for update wallet ammount, change withdraw status, insert to table transaction and  make notification
            Wallet::where('id', $withdrawal->wallet->id)->update($walletAmmount);
            Withdrawal::where('id',$id)->update($withdrawStatusAtr);
            app(TransactionInterface::class)->insert($transactionParameters);
            app(NotificationInterface::class)->create($notificationParameter);

            DB::commit();

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_SUCCESS, __('Withdrawal has been successfully Declined.'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to update the wallet balance.'));
        }
    }


    public function approveBank($id)
    {
        $attributes = ['status' => PAYMENT_COMPLETED];
        $conditions = [ 'id' => $id, 'status' => PAYMENT_REVIEWING ];
        $notifparam = $this->withdrawalRepository->getFirstByConditions(['id' => $id, 'status' => PAYMENT_REVIEWING], ['stockItem']);

        if( $this->withdrawalRepository->updateByConditions($attributes, $conditions) )
        {
            dispatch( new StockItemWithdrawal($id) );

             $notificationParameter = [
                'user_id' => $notifparam->user_id,
                'data' => __("Your Withdrawal Has Been Approved and Your :currency wallet has been decreased by system.", [
                    'currency' => $notifparam->stockItem->item
                ]),
            ];

            app(NotificationInterface::class)->create($notificationParameter);

            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The withdrawal Bank has been approved successfully.'));
        }

        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Invalid Request.'));
    }
}

/*
    END Doc Code 1

*/
