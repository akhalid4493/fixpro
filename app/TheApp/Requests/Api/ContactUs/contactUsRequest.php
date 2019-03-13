<?php

namespace App\TheApp\Requests\Api\ContactUs;

use Illuminate\Foundation\Http\FormRequest;
use App\TheApp\Requests\Api\ApiRequest;

class contactUsRequest extends ApiRequest
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
        return 
        [
            'name'       => 'required|min:3',
            'email'      => 'required|email',
            'message'    => 'required|min:6',
        ];

    }

    public function messages()
    {
        return [
            'name.required'   => 'من فضلك ادخل الاسم الخاص بك',
            'name.min'        => 'يجب الا يقل الاسم عن ثلاث احرف',

            'email.required'  => 'من فضلك ادخل البريد الالكتروني',
            'email.email'     => 'من فضلك ادخل البريد بشكل صحيح',

            'message.required'=> 'من فضلك ادخل الرسالة النصية',
            'message.min'     => 'يجب الا تقل الرسالة النصية عن ستة احرف',
        ];
    }
}
