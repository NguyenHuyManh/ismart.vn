<?php

namespace App\Compoments;

use App\Category;

class CategoryRecusive
{
    private $html;
    public function __construc()
    {
        $this->html = "";
    }
    public function categoryRecusiveAdd($parentId = 0, $text = "")
    {
        $data = Category::where('parent_id', $parentId)->get();
        foreach ($data as $value) {
            if($value['status'] == 1){
                $this->html .= "<option value='" . $value['id'] . "'>" . $text . $value->name . "</option>";
            }         
            $this->categoryRecusiveAdd($value['id'], $text ."--");
        }
        return $this->html;
    }

    public function categoryRecusiveEdit($parentIdEdit, $parentId = 0, $text = "")
    {
        $data = Category::where('parent_id', $parentId)->get();
        foreach ($data as $value) {
            if($parentIdEdit == $value['id']){
                $this->html .= "<option selected value='" . $value['id'] . "'>" . $text . $value->name . "</option>";
            }else{
                $this->html .= "<option value='" . $value['id'] . "'>" . $text . $value->name . "</option>";
            }
                   
            $this->categoryRecusiveEdit($parentIdEdit, $value['id'], $text ."--");
        }
        return $this->html;
    }
}
