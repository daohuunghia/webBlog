<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleRequest extends FormRequest
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
            'vi_name' => 'required',
            'en_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'vi_name.required' => trans('backend.Nội dung không được trống'),
            'en_name.required' => trans('backend.Nội dung không được trống')
        ];
    }
}
