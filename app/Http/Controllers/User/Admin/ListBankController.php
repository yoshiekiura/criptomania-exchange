<?php

namespace App\Http\Controllers\user\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Admin\ListBankRequest;
use App\Repositories\User\Admin\Interfaces\ListBankInterface;
use App\Repositories\User\Trader\Interfaces\WalletInterface;
use App\Repositories\User\Trader\Interfaces\BankNameInterface;
use App\Services\Core\DataListService;
use App\Services\Core\FileUploadService;
use Illuminate\Support\Facades\DB;

/*
    Developer   : Muhammad Rizky Firdaus
    Date        : 20-07-2020
    Description : Controller for trader bank account CRUD

*/

class ListBankController extends Controller
{
	public $listBank;
    public $bankName;


 	public function __construct(ListBankInterface $listBank, BankNameInterface $bankName)
 	{
 		$this->listBank = $listBank;
        $this->bankName = $bankName;

 	}   

 	public function index(){

 		$searchFields = [
            ['bank_name', __('Bank Name')],
            ['account_number', __('Account Number')],
        ];

        $orderFields = [
            ['bank_name', __('Bank Name')],
            ['account_number', __('Account Number')],
            ['list_bank.created_at', __('Created Date')],
        ];

        $query = $this->listBank->paginateWithFilters($searchFields, $orderFields);
        $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        $data['title'] = __('List Bank');

        return view('backend.listBank.index', $data);

 	}

    // this is to show trader
    public function traderBank()
    {
        $searchFields = [
            ['users_id', __('User ID')],
            ['bank_name', __('Bank Name')],
            ['account_number', __('Account Number')],
        ];

        $orderFields = [
            ['users_id', __('User ID')],
            ['bank_name', __('Bank Name')],
            ['account_number', __('Account Number')],
            ['list_bank.created_at', __('Created Date')],
        ];

        $query = $this->bankName->paginateWithFilters($searchFields, $orderFields);
        $data['list'] = app(DataListService::class)->dataList($query, $searchFields, $orderFields);
        $data['title'] = __('List Bank');

        return view('backend.listBank.traderBankIndex', $data);
    }
 	
    public function create()
    {
        $data['title'] = __('Create New Bank Number');

        return view('backend.listBank.create', $data);
    }

    public function store(ListBankRequest $request)
    {
        try {
            DB::beginTransaction();
            $attributes = $request->only('bank_name','account_number');

            $this->listBank->create($attributes);

            DB::commit();

            return redirect()->route('admin.list-bank.index')->with(SERVICE_RESPONSE_SUCCESS, __('The Bank Name has been created successfully.'));
        }
        catch (\Exception $exception) {
            DB::rollBack();
            if($exception->getCode() == 23000) {
                return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('The Bank Name already exists.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to create Bank Name.'));
        }
    }

    public function edit($id)
    {
        $data['title'] = __('Edit Bank Name');
        $data['listBank'] = $this->listBank->findOrFailById($id);

        return view('backend.listBank.edit', $data);
    }

     public function update(ListBankRequest $request, $id)
    {
        $attributes = $request->only('bank_name', 'account_number');

        if ($this->listBank->update($attributes, $id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The Bank Name has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to update.'));
    }


     public function destroy($id)
    {
        try {
            if ($this->listBank->deleteById($id)) {
                return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The Bank name has been deleted successfully.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete.'));
        } catch (\Exception $exception) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete as the Bank Name is being used.'));
        }
    }

      public function show($id)
    {
        $data['title'] = __('Bank Name');
        $data['listBank'] = $this->listBank->findOrFailById($id);

        return view('backend.listBank.show', $data);
    }

}
