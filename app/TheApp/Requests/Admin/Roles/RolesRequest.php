<?php

namespace App\TheApp\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
            'name'       => 'required|unique:roles,name|regex:/^[\pL\s\-]+$/u',
            'permission' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required'        => 'من فضلك ادخل عنوان المجموعة.',
            'name.unique'          => 'هذا العنوان موجود بالفعل.',
            'name.regex'           => 'يجب ان يحتوي العنوان على حروف فقط.',
            'permission.required'  => 'من فضلك قم بتحديد الصلاحيات لهذة المجموعة.',
        ];
    }
}
