<?php

namespace App\Http\Requests\Core;

// use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;


class RpcRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
  public function rules()
    {
        $rpcRequest = [
            'stock_item_id' => 'required',
            'scheme' => 'required|max:255',
            'host' => 'required|max:255',
            'port' => 'required|numeric',
            'rpc_user' => 'required|max:255',
            'rpc_password' => 'required|max:255',
            'network_fee' => 'required|numeric|between:0, 99999999999.99',
            'cert_ca' => 'nullable|max:255',

            
        ];

        return $rpcRequest;
    }
}
