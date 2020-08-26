<?php

namespace App\Http\Requests\User\Admin;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApiServiceRequest extends Request
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
        $apiServiceReq = [
            'api_value' => 'required|numeric',
            'api_name' => [
                'required',
                Rule::unique('api_stock_item'),
                'max:255'
            ],
            
        ];

        return $apiServiceReq;
    }

    public function attributes()
    {
        return [
            'api_value' => __('Api Value'),
            'api_name' => __('Api Name'),
        ];
    }
}
