<?php

namespace App\Http\Controllers\Fontend;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Post;
use App\Product;
use App\Purchase_policy;
use Illuminate\Http\Request;

class PurchasePolicyController extends Controller
{
    private $banner;
    private $product;
    private $purchase_policy;

    public function __construct(Product $product, Banner $banner, Purchase_policy $purchase_policy)
    {
        $this->product = $product;
        $this->banner = $banner;
        $this->purchase_policy = $purchase_policy;
    }

    public function show($slug, $id)
    {
        $item = $this->purchase_policy->find($id);

        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //============= Sản phẩm bán chạy ===========
        $productPay = $this->product
            ->where([
                ['pro_pay', '>=', 15],
                ['status', 1]
            ])->limit(8)->get();

        return view('fontend.purchase-policy.show', compact('item', 'productPay', 'banner'));
    }
}
