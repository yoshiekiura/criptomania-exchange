<?php

namespace App\Http\Controllers\User\Trader;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Trader\DepositRequest;
use App\Http\Requests\User\Trader\DepositBankRequest;
use App\Http\Requests\User\Trader\WithdrawalRequest;
use App\Jobs\StockItemWithdrawal;
use App\Repositories\User\Admin\Interfaces\TransactionInterface;
use App\Repositories\User\Interfaces\NotificationInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\WithdrawalInterface;
use App\Services\User\Trader\WalletService;
use App\Repositories\User\Admin\Interfaces\ListBankInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User\Deposit;
use App\Models\Backend\StockItem;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\User\Trader\StruckUploadRequest;
use App\Services\Core\FileUploadService;
use App\Repositories\User\Admin\Interfaces\StockItemInterface;
use App\Repositories\User\Trader\Interfaces\DepositBankInterface;
use App\Events\Exchange\BroadcastNotification;
use \Illuminate\Support\Facades\Route;


class WalletController extends Controller
{
    private $walletRepository;
    private $walletService;
    private $bankAdmin;
    private $depoBankRepo;
    private $notification;

    public function __construct(WalletInterface $walletRepository, WalletService $walletService, ListBankInterface $bankAdmin, DepositBankInterface $depoBankRepo, NotificationInterface $notification)
    {
        $this->walletRepository = $walletRepository;
        $this->walletService = $walletService;
        $this->bankAdmin = $bankAdmin;
        $this->depoBankRepo = $depoBankRepo;
        $this->notification = $notification;
    }

    /*
        Modified by : Muhammad Rizky Firdaus & Muhammad Fatur Prayuda
        Date        : 13-08-2020
        Description : 

    */
    public function walletJsonIndex()
    {
        $this->walletRepository->createUnavailableWallet(Auth::id());
        $data = $this->walletRepository->getWalletJsonTrader(Auth::id());

        return $data;

    }
    public function index()
    {
        $this->walletRepository->createUnavailableWallet(Auth::id());
        $data['title'] = __('Wallets');
        return view('frontend.wallets.index', $data);
    }

    public function createDeposit($id)
    {
        $data['wallet'] = $this->walletRepository->findOrFailByConditions(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        // $data['bankAdmin'] = $this->bankAdmin->getAllListBank();
        $data['title'] = __('Wallets');

        if ($data['wallet']->stockItem->item_type == CURRENCY_CRYPTO) {
            $data['walletAddress'] = __('Deposit is currently disabled.');

            if ($data['wallet']->stockItem->deposit_status == ACTIVE_STATUS_ACTIVE) {
                if (!empty($data['wallet']->address)) {
                    $data['walletAddress'] = $data['wallet']->address;
                } else {
                    $data['walletAddress'] = $this->walletService->generateWalletAddress($data['wallet']);
                }
            }

            return view('frontend.wallets.wallet_address', $data);
        } 

        elseif ($data['wallet']->stockItem->item_type == CURRENCY_REAL) 
        {
            if($data['wallet']->stockItem->item_type == CURRENCY_REAL && $data['wallet']->stockItem->api_service == BANK_TRANSFER)
            {
                return view('frontend.wallets.deposit_bank_form', $data);

            }
            else
            {
                return view('frontend.wallets.deposit_form', $data);

            }
        }

        else 
        {
            return view('errors.404', $data);
        }
    }

    public function storeDeposit(DepositRequest $request, $id)
    {
        $response = $this->walletService->storeDeposit($request, $id);
        $wallet = $this->walletRepository->getFirstByConditions(['id' => $id, 'user_id' => Auth::id()], 'stockItem');


        if ($response[SERVICE_RESPONSE_STATUS] == true) {
            return redirect()->route('trader.wallets.index')->with(SERVICE_RESPONSE_SUCCESS, $response[SERVICE_RESPONSE_MESSAGE]);
        }


        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, $response[SERVICE_RESPONSE_MESSAGE]);

    }
    /* 
        Developer   : Muhammad Rizky Firdaus
        Date        : 20-02-2020
        Description : method storeDepositWithBank is used for deposit with bank transfer, especially in IDR Currency

        NOTE :  THIS METHOD CAN USE TO ANOTHER CURRENCY WHICH IS USE BANK TRANSFER TYPE TO DEPOSIT

    */

    public function storeDepositWithBank(DepositBankRequest $request, $id)
    {
        $wallet = $this->walletRepository->getFirstByConditions(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        $date = now();

          if($wallet->stockItem->api_service == BANK_TRANSFER){

            try {
                DB::beginTransaction();

                 $depositParameters = [
                'ref_id' => (string)Str::uuid(),
                'users_id' => $wallet->user_id,
                'wallet_id' => $wallet->id,
                'stock_item_id' => $wallet->stock_item_id,
                'admin_bank_id' => $request->admin_bank_id,
                'amount' => $request->amount,
                'created_at' => $date,
                'updated_at' => $date,
            ];

        // dd($depositParameters);
            $insert = DepositBankTransfer::create($depositParameters);
            if ($insert) {
            $notification = ['user_id' => 1, 
                             'data' => __("The user with :email was deposit with bank transfer please check your reviews",[
                                'email' => Auth::user()->email
                             ]),
                            ];
            // app(NotificationInterface::class)->create($notification);

                 $notif = $this->notification->create($notification);
            
        }

         DB::commit();
         if($notif)
         {
             
             event(new BroadcastNotification($notification));
         }
       

            return redirect()->route('trader.wallets.invoice',$insert->id)->with(SERVICE_RESPONSE_SUCCESS, __('Your Deposit Transfer has been successfully insert. Please Upload Your Struck Upload'));

            }catch(Exception $exception)
            {
                DB::rollBack();
                return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create deposit. Please Fill All Input Fields.'));

            }

           
        }

    }

    public function showInvoice($id)
    {
        $data['title'] = __('Invoice');
        $data['depoBank'] = $this->depoBankRepo->getDepositBankByCondition(['deposit_bank_transfer.id' => $id]);
        return view('frontend.wallets.invoice_bank', $data);
    }

    public function struckUpload(StruckUploadRequest $request, $id)
    {
        $response = $this->walletService->struckUpload($request, $id);

        $notifToAdmin = __("User with :email Has Been Upload Struck In :withdrawId withdrawal check your reviews", [
                    'withdrawId' => $id,
                    'email' => Auth::user()->email
                ]);


        if($response)
        {
            app(NotificationInterface::class)->create([
                'user_id' => 1,
                'data' => $notifToAdmin
                ]);
        }
        $status = $response[SERVICE_RESPONSE_STATUS] ? SERVICE_RESPONSE_SUCCESS : SERVICE_RESPONSE_ERROR;

        // dd($response);

        return redirect()->back()->with($status, $response[SERVICE_RESPONSE_MESSAGE]);

    }

    public function updateStatusBankTransfer($id)
    {
         $attributes = $request->only('status');

        if ($this->depoBankRepo->update($attributes, $id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The Status has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to update.'));
    }
        /*
            
            This is end method bank transfer deposit

        */


    // paypal return url
    public function completePayment(Request $request)
    {
        $response = $this->walletService->completePayment($request);
        $return = [SERVICE_RESPONSE_ERROR => $response[SERVICE_RESPONSE_MESSAGE]];

        if ($response[SERVICE_RESPONSE_STATUS] == true) {
            $return = [SERVICE_RESPONSE_SUCCESS => $response[SERVICE_RESPONSE_MESSAGE]];
        }

        return redirect()->route('trader.wallets.index')->with($return);
    }

    // paypal cancel url
    public function cancelPayment()
    {
        $response = $this->walletService->cancelPayment();

        return redirect()->route('trader.wallets.index')->with([SERVICE_RESPONSE_WARNING => $response[SERVICE_RESPONSE_MESSAGE]]);
    }

    public function createWithdrawal($id)
    {
        $data['wallet'] = $this->walletRepository->findOrFailByConditions(['id' => $id, 'user_id' => Auth::id()], 'stockItem');
        $data['title'] = __('Wallets');

        return view('frontend.wallets.withdrawal_form', $data);
    }


    /*
        Modified by : Muhammad Rizky Firdaus
        Date        : 21-07-2020
        Description : Update method withdraw for bank transfer from line 309 to End Line
        Method      : storeWithdrawal()

    */

    public function storeWithdrawal(WithdrawalRequest $request, $id)
    {
        $wallet = $this->walletRepository->getFirstByConditions(['id' => $id, 'user_id' => Auth::id()], 'stockItem');

        if (empty($wallet) || !in_array($wallet->stockItem->item_type, config('commonconfig.currency_transferable'))) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Invalid request.'));
        }

        if ($wallet->stockItem->withdrawal_status != ACTIVE_STATUS_ACTIVE) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Withdrawal is currently disabled.'));
        }

        if ( $wallet->primary_balance < $request->amount ) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('You don\'t have enough balance.'));
        }

        if ( $request->amount < $wallet->stockItem->minimum_withdrawal_amount ) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Minimum withdrawal amount :amount :stockItem', [ 'amount' => $wallet->stockItem->minimum_withdrawal_amount, 'stockItem' => $wallet->stockItem->item]));
        }

        $last24hrWithrawalAmount = app(WithdrawalInterface::class)->getLast24hrWithrawalAmount(['wallet_id' => $wallet->id, 'user_id' => Auth::id()]);

        if (bcadd($last24hrWithrawalAmount, $request->amount) > $wallet->stockItem->daily_withdrawal_limit) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Daily withdraw limit is already exceeded.'));
        }

        // started code here
        $systemFee = bcdiv(bcmul($request->amount, $wallet->stockItem->withdrawal_fee), '100');

        $attributes = ['primary_balance' => DB::raw('primary_balance - ' . $request->amount)];
        $conditions = ['id' => $wallet->id, 'user_id' => auth()->id()];

        try {
            DB::beginTransaction();

            if (!$this->walletRepository->updateByConditions($attributes, $conditions))
            {
                throw new \Exception(__('Failed to withdraw the amount. Please try again.'));
            }
            // create withdrawal
            $withdrawalRepository = app(WithdrawalInterface::class);

            $withdrawalRepositoryBank = app(WithdrawalInterface::class);

            
                 $withdrawalBankAtr = [

                'user_id' => auth()->id(),
                'ref_id' => (string)Str::uuid(),
                'wallet_id' => $wallet->id,
                'stock_item_id' => $wallet->stock_item_id,
                'amount' => $request->amount,
                'system_fee' => $systemFee,
                'address' => $request->address,
                'status' => admin_settings('auto_withdrawal_process') == ACTIVE_STATUS_ACTIVE ? PAYMENT_REVIEWING : PAYMENT_PENDING,
                'payment_method' => $wallet->stockItem->api_service,
            ];
                 $withdrawalAttriburtes = [

                'user_id' => auth()->id(),
                'ref_id' => (string)Str::uuid(),
                'wallet_id' => $wallet->id,
                'stock_item_id' => $wallet->stock_item_id,
                'amount' => $request->amount,
                'system_fee' => $systemFee,
                'address' => $request->address,
                'status' => admin_settings('auto_withdrawal_process') != ACTIVE_STATUS_ACTIVE ? PAYMENT_REVIEWING : PAYMENT_PENDING,
                'payment_method' => $wallet->stockItem->api_service,
            ];


            if($wallet->stockItem->api_service == BANK_TRANSFER)
            {
            $withdrawal = $withdrawalRepository->create($withdrawalBankAtr);

            }
            else
            {
            
            $withdrawal = $withdrawalRepository->create($withdrawalAttriburtes);

            }


            $date = now();
            $transactionParameters = [
                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($wallet),
                    'model_id' => $wallet->id,
                    'transaction_type' => TRANSACTION_TYPE_DEBIT,
                    'amount' => bcmul($withdrawal->amount, '-1'),
                    'journal' => DECREASED_FROM_WALLET_ON_WITHDRAWAL_REQUEST,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],

                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($withdrawal),
                    'model_id' => $withdrawal->id,
                    'transaction_type' => TRANSACTION_TYPE_TRANSFER,
                    'amount' => bcmul($systemFee, '-1'),
                    'journal' => DECREASED_FROM_WITHDRAWAL_AS_WITHDRAWAL_FEE_ON_WITHDRAWAL_CONFIRMATION,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],

                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($withdrawal),
                    'model_id' => $withdrawal->id,
                    'transaction_type' => TRANSACTION_TYPE_CREDIT,
                    'amount' => $withdrawal->amount,
                    'journal' => INCREASED_TO_WITHDRAWAL_ON_WITHDRAWAL_REQUEST,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],

                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($withdrawal),
                    'model_id' => $withdrawal->id,
                    'transaction_type' => TRANSACTION_TYPE_TRANSFER,
                    'amount' => $withdrawal->amount,
                    'journal' => INCREASED_TO_WITHDRAWAL_ON_WITHDRAWAL_REQUEST,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],

                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => get_class($withdrawal),
                    'model_id' => $withdrawal->id,
                    'transaction_type' => TRANSACTION_TYPE_DEBIT,
                    'amount' => bcmul($systemFee, '-1'),
                    'journal' => DECREASED_FROM_WITHDRAWAL_AS_WITHDRAWAL_FEE_ON_WITHDRAWAL_CONFIRMATION,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],
                [
                    'user_id' => auth()->id(),
                    'stock_item_id' => $withdrawal->stock_item_id,
                    'model_name' => null,
                    'model_id' => null,
                    'transaction_type' => TRANSACTION_TYPE_CREDIT,
                    'amount' => $systemFee,
                    'journal' => INCREASED_TO_SYSTEM_ON_AS_WITHDRAWAL_FEE_WITHDRAWAL_CONFIRMATION,
                    'updated_at' => $date,
                    'created_at' => $date,
                ]
            ];
            app(TransactionInterface::class)->insert($transactionParameters);
            // notify user

            $notificationMessage = __("Your request for withdrawal :amount :stockItem to :address is now reviewing by system. You will be notified when it's transfered.", ['amount'=> $withdrawal->amount,'stockItem' => $wallet->stockItem->item,'address' => $withdrawal->address]);

            if( admin_settings('auto_withdrawal_process') == ACTIVE_STATUS_ACTIVE )
            {
                $notificationMessage = __("Your request for withdrawal :amount :stockItem to :address is now pending.", ['amount'=> $withdrawal->amount,'stockItem' => $wallet->stockItem->item,'address' => $withdrawal->address]);

                $notificationMessageBankwd = __("Your request for withdrawal :amount :stockItem to :address with bank is under review.", ['amount'=> $withdrawal->amount,'stockItem' => $wallet->stockItem->item,'address' => $withdrawal->address]);

                $notifToAdmin = __("User with :email Request for withdrawal :amount :stockItem to :address", [
                    'amount'=> $withdrawal->amount,
                    'stockItem' => $wallet->stockItem->item,
                    'address' => $withdrawal->address,
                    'email' => Auth::user()->email
                ]);
            }

            if($wallet->stockItem->api_service == BANK_TRANSFER)
            {
                app(NotificationInterface::class)->create([
                'user_id' => auth()->id(),
                'data' => $notificationMessageBankwd
                ]);
            }

            else
            {
                 app(NotificationInterface::class)->create([
                'user_id' => auth()->id(),
                'data' => $notificationMessage
             ]);
            }

           

            app(NotificationInterface::class)->create([
                'user_id' => 1,
                'data' => $notifToAdmin
            ]);

            $message = __("Your withdrawal request has been placed for reviewing. You will be notified when it's transfered.");

            if( admin_settings('auto_withdrawal_process') == ACTIVE_STATUS_ACTIVE )
            {
                $message = __("Your withdrawal request has been placed successfully.");
                dispatch(new StockItemWithdrawal($withdrawal->id));
            }
            elseif (admin_settings('auto_withdrawal_process') == ACTIVE_STATUS_ACTIVE && $wallet->stockItem->api_service == BANK_TRANSFER)
            {
                $message = __("Your withdrawal bank request has been placed successfully ");
                dispatch(new StockItemWithdrawal($withdrawal->id));

            }

            DB::commit();

            return redirect()->route('reports.trader.withdrawals', ['id' => $wallet->id])->with(SERVICE_RESPONSE_SUCCESS, $message);
        }
        catch (\Exception $exception)
        {
            DB::rollBack();

            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to withdraw the amount. Please try again.'));
        }
    }
}