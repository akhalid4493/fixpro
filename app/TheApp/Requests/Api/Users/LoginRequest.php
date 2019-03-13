<?php

namespace App\TheApp\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\TheApp\Requests\Api\ApiRequest;

class LoginRequest extends ApiRequest
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
        return [
             'password'       =>'required',
             'email'          =>'required|email',
        ];
    }

        public function messages()
    {
        return [
            'email.required'        => 'Please Enter Your Email',
            'password.required'     => 'Please Enter Your Password',
            'email.email'           => 'This email format maybe wrong , please try again',
        ];
    }
}
