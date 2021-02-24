<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'name' => 'required',
            'amount' => 'required',
            'price' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => 'Không đúng định dạng file ảnh!',
            'avatar.image' => 'Không đúng định dạng file ảnh!',
            'avatar.max' => 'Dung lượng file ảnh tối đa 1M!',
            'avatar.required' => 'Ảnh đại diện không được để trống!',
            'name.required' => 'Tên sản phẩm không được để trống!',
            'amount.required' => 'Số lượng không được để trống!',
            'price.required' => 'Giá sản phẩm không được để trống!',
            'content.required' => 'Mô tả chi tiết không được để trống!',
            'category_id.required' => 'Bạn phải chọn danh mục!',
        ];
    }
}
