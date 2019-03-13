<?php

namespace App\TheApp\Requests\Api\Common;

use Illuminate\Foundation\Http\FormRequest;
use App\TheApp\Requests\Api\ApiRequest;

class CommonRequest extends ApiRequest
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
             'user_id'         =>'required',
             'api_token'       =>'required',
        ];
    }

        public function messages()
    {
        return [
            'user_id.required'      => 'من فضلك ادخ { user_id }',
            'api_token.required'    => 'من فضلك ادخل { api_token }',
        ];
    }
}
