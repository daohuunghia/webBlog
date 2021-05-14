<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'password' => 'required|min:6|max:20',
            're_password' => 'required|same:password',
            'avatar' => 'required',
            'phone' => 'min:10|max:11|unique:users,phone,' . $this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên đăng nhập không được trống',
            'name.min' => 'Tên đăng nhập có độ dài từ 3 đến 20 kí tự',
            'name.max' => 'Tên đăng nhập có độ dài từ 3 đến 20 kí tự',
            'email.required' => 'Email không được trống',
            'email.unique' => 'Email đã tồn tại trên hệ thống',
            'email.email' => 'Email chưa đúng định dạng',
            'password.required' => 'Mật khẩu không được trống',
            'password.min' => 'Mật khẩu có độ dài từ 6 đến 20 kí tự',
            'password.max' => 'Mật khẩu có độ dài từ 6 đến 20 kí tự',
            're_password.required' => 'Mật khẩu không được trống',
            're_password.same' => 'Mật khẩu nhập lại chưa khớp',
            'avatar.required' => 'Vui lòng upload một bức ảnh về bạn',
            'phone.min' => 'Số điện thoại có độ dài từ 6 đến 20 kí tự',
            'phone.max' => 'Số điện thoại có độ dài từ 6 đến 20 kí tự',
            'phone.unique' => 'Số điện thoại đã tồn tại trên hệ thống',
        ];
    }
}
