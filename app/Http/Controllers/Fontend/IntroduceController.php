<?php

namespace App\Http\Controllers\Fontend;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Introduce;
use App\Product;
use Illuminate\Http\Request;

class IntroduceController extends Controller
{
    private $banner;
    private $product;
    private $introduce;

    public function __construct(Product $product, Banner $banner, Introduce $introduce)
    {
        $this->product = $product;
        $this->banner = $banner;
        $this->introduce = $introduce;
    }

    public function index()
    {
        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //============= Sản phẩm bán chạy ===========
        $productPay = $this->product
            ->where([
                ['pro_pay', '>=', 15],
                ['status', 1]
            ])->limit(8)->get();

        //============== Giới thiệu =============
        $introduce = $this->introduce->find(1);


        return view('fontend.intro.index', compact('banner', 'productPay', 'introduce'));
    }
}
