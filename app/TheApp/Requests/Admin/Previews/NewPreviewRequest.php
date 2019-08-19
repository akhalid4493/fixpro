<?php

namespace App\TheApp\Requests\Admin\Previews;

use Illuminate\Foundation\Http\FormRequest;

class NewPreviewRequest extends FormRequest
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
            'user_id'     => 'required',
            'address_id'  => 'required',
            'time'        => 'required',
            'date'        => 'required',
            'service_id'  => 'required',
         ];
    }

    public function messages()
    {
        return [

            'user_id.required'      => 'من فضلك اختر المستخدم',
            'address_id.required'   => 'من فضلك اختر العنوان',
            'service_id.required'   => 'من فضلك اختر الخدمة',
            'time.required'         => 'من فضلك اختر الموعد',
            'date.required'         => 'من فضلك اختر التاريخ',

        ];
    }
}
