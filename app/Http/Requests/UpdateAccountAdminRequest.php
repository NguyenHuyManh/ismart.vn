<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountAdminRequest extends FormRequest
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
            'phone' => 'required|numeric|digits:10',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống!',
            'phone.required' => 'Số điện thoại pkhông được để trống!',
            'phone.numeric' => 'Số điện thoại phải là chữ số!',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số!',
        ];
    }
}
