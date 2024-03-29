<?php

namespace App\Http\Controllers\User\Trader;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Trader\BankNameRequest;
use App\Repositories\User\Trader\Interfaces\BankNameInterface;
use App\Services\Core\DataListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\User\ProfileService;

/*
    Developer   : Muhammad Rizky Firdaus
    Date        : 20-07-2020
    Description : Controller for superadmin bank account CRUD

*/


class BankNameController extends Controller
{
    public $bankName;
    private $service;


 	public function __construct(BankNameInterface $bankName, ProfileService $service)
 	{
 		$this->bankName = $bankName;
        $this->service = $service;


 	}   

    public function bankTraderJson()
    {
        return $this->bankName->getAllListBankJson(Auth::id());
    }

 	public function index(){

        return view('backend.userBank.index');
 	}


    public function edit($id)
    {
        $data['title'] = __('Edit Bank Name');
        $data['bankName'] = $this->bankName->findOrFailById($id);

        return view('backend.userBank.edit', $data);
    }

     public function update(BankNameRequest $request, $id)
    {
        $attributes = $request->only('bank_name', 'account_number');

        if ($this->bankName->update($attributes, $id)) {
            return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The Bank Name has been updated successfully.'));
        }

        return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to update.'));
    }


     public function destroy($id)
    {
        try {
            if ($this->bankName->deleteById($id)) {
                return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('The Bank name has been deleted successfully.'));
            }

            return redirect()->back()->withInput()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete.'));
        } catch (\Exception $exception) {
            return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to delete as the Bank Name is being used.'));
        }
    }
}
