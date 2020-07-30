<?php

namespace App\Http\Requests\User\Admin;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ListBankRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $listBankRequest = [
            'bank_name' => 'required|max:255',
            'account_number' => 'required|numeric',
            
        ];

        return $listBankRequest;
    }

    public function attributes()
    {
        return [
            'bank_name' => __('Bank Name'),
            'account_number' => __('Account Number'),
        ];
    }
}
