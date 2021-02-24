<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAdminRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:32',
            'password_confirm' => 'required|same:password',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không đúng định dạng!',
            'email.unique' => 'Email đã được sử dụng!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
            'password.max' => 'Mật khẩu tối đa 32 kí tự!',
            'password_confirm.required' => 'Mật khẩu xác thực không được trống!',
            'password_confirm.same' => 'Mật khẩu xác thực không đúng!',
        ];
    }
}
