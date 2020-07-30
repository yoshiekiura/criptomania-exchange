<?php

namespace App\Http\Requests\User\Trader;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class StruckUploadRequest extends Request
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
            'payment_prove' => 'required|image|max:2048'
            
        ];
    }
}
