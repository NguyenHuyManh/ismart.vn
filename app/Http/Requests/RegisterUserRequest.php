<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|numeric|digits:10|unique:customers',
            'password' => 'required|min:6|max:32',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không đúng định dạng!',
            'email.unique' => 'Email đã được đăng kí!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
            'password.max' => 'Mật khẩu tối đa 32 kí tự!',
            'phone.required' => 'Số điện thoại không được để trống!',
            'phone.numeric' => 'Số điện thoại phải là chữ số!',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số!',
            'phone.unique' => 'Số điện thoại đã được đăng kí!',
            'password_confirmation.required' => 'Mật khẩu xác thực không được trống!',
            'password_confirmation.same' => 'Mật khẩu xác thực không đúng!'
        ];
    }
}
