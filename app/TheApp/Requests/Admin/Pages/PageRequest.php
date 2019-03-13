<?php

namespace App\TheApp\Requests\Admin\Pages;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title_ar'        => 'required|unique:pages,title_ar',
            'title_en'        => 'required|unique:pages,title_en',
            'content_en'      => 'required',
            'content_ar'      => 'required',
         ];
    }

    public function messages()
    {
        return [

            'title_ar.required'   => 'من فضلك ادخل عنوان القسم بالعربي',
            'title_ar.unique'     => 'عنوان القسم بالعربي تم ادخالة من قبل',

            'title_en.required'   => 'من فضلك ادخل عنوان القسم بالانجليزي',
            'title_en.unique'     => 'القسم بالانجليزي تم ادخالة من قبل',
            
        ];
    }
}
