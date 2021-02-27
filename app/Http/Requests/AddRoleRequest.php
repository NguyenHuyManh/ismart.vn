<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRoleRequest extends FormRequest
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
            'display_name' => 'required',
            'permission_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nhóm quyền không được để trống!',
            'display_name.required' => 'Mô tả nhóm quyền không được để trống!',
            'permission_id.required' => 'Vui lòng lựa chọn các chức năng để ủy quyền!'
        ];
    }
}
