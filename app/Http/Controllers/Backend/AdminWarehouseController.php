<?php

namespace App\Http\Controllers\Backend;

use App\Product;
use App\Product_image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\UploadImageTrait;
use App\Compoments\CategoryRecusive;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUpdateRequest;

class AdminWarehouseController extends Controller
{
    use UploadImageTrait;

    private $categoryRecusive;
    private $product;
    private $product_image;
    public function __construct(CategoryRecusive $categoryRecusive, Product $product, Product_image $product_image)
    {
        $this->categoryRecusive = $categoryRecusive;
        $this->product = $product;
        $this->product_image = $product_image;
    }

    public function index(Request $request)
    {
        $keyword = '';
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        $products = $this->product->latest()->where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        return view('backend.warehouse.index', compact('products'));
    }


    //===== Cập nhật số lượng sản phẩm ===========
    public function updateAmountProduct(Request $request, $id)
    {
        $amount = $request->input('update_amount');
        $this->product->where('id', $id)->increment('amount', $amount);

        return back()->with('toast_success', 'Cập nhập số lượng thành công!');
    }
}
