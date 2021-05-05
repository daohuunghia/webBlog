<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryRequest extends FormRequest
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
            'vi_title' => 'required|max:255',
            'en_title' => 'required|max:255',
            'vi_keyword' => 'required',
            'en_keyword' => 'required',
            'vi_description' => 'required',
            'en_description' => 'required'
        ];
    }
}
