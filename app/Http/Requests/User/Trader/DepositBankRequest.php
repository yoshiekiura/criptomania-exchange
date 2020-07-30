<?php

namespace App\Http\Requests\User\Trader;

// use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class DepositBankRequest extends Request
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
        return [
            'amount' => 'required|numeric|between:100000, 100000000',
            'accept_policy' => 'required|in:1',
            'admin_bank_id' => 'required',
            // 'status' => 'required|in:2,3',

        ];
    }

    public function attributes()
    {
        return [
            'accept_policy' => __('The deposit policy checking'),
        ];
    }
}
