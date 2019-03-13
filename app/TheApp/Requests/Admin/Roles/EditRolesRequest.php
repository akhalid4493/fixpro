<?php

namespace App\TheApp\Requests\Admin\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EditRolesRequest extends FormRequest
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
            'name'        => 'required|regex:/^[\pL\s\-]+$/u|unique:roles,name,'.$this->route('role'),
            'permission'  => 'required',
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
