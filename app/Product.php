<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    //Lấy ra sản phẩm thuộc danh mục nào
    public  function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    //Lấy ra sản phẩm thuộc user nào tạo ra
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Lấy ra ảnh chi tiết thuộc sản phẩm
    public function imageDetails()
    {
        return $this->hasMany(Product_image::class, 'product_id');
    }

}
