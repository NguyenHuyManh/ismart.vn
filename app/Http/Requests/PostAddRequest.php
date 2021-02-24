<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAddRequest extends FormRequest
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
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'title' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' => 'Không đúng định dạng file ảnh!',
            'avatar.image' => 'Không đúng định dạng file ảnh!',
            'avatar.max' => 'Dung lượng file ảnh tối đa 1M!',
            'title.required' => 'Tiêu đề bài viết không được để trống!',
            'content.required' => 'Nội dung bài viết không được để trống!',
        ];
    }
}
