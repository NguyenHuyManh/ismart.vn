<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    //====== Lấy ra danh mục con
    public function categoryChildrent()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //======== Lấy ra sảm phẩm thuộc danh mục 
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
