<?php

namespace App\TheApp\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email,'.$this->id,
            'mobile'      => 'required|numeric',
            'active'      => 'required',
            'password'    => 'nullable|min:6|confirmed',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2050',
         ];
    }

    public function messages()
    {
        return [

            'name.required'   => 'من فضلك ادخل اسم المستخدم بالكامل.',
            
            'email.required'      => 'من فضلك ادخل البريد الالكتروني.',
            'email.email'         => 'من فضلك ادخل البريد بشكل صحيح { email@example.com }.',
            'email.unique'        => $this->id,

            'country.required'     => 'من فضلك اختر الدولة ',

            'password.min'         => 'يجب الا تقل كلمة المرور عن ٦ احرف او ارقام.',
            'password.confirmed'   => 'تآكيد كلمة المرور غير متطابقة.',

            'mobile.required'     => 'من فضلك ادخل رقم الهاتف.',
            'mobile.numeric'      => 'يحب ان يتكون رقم الهاتف من ارقام فقط.',

            'active.required'     => 'من فضلك قم بتحديد التفعيل للعميل.',


            'image.image'           => 'هذا الملف ليس صورة',
            'image.mimes'           => 'يجب ان تكون الصوره من نوع [ jpg , png ] .',
            'image.max'             => 'الحجم يجب الا يكون اكبر من  2 MB  للغلاف.',            

        ];
    }
}