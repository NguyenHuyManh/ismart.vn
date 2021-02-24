<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use App\Contact;
use App\Product;

class ContactController extends Controller
{
    private $banner;
    private $product;
    private $contact;

    public function __construct(Product $product, Banner $banner, Contact $contact)
    {
        $this->product = $product;
        $this->banner = $banner;
        $this->contact = $contact;
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

        //=============== Liên hệ ====================
        $contact = $this->contact->find(1);

        return view('fontend.contact.index', compact('banner', 'productPay', 'contact'));
    }
}
