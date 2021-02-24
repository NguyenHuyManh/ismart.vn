<?php

namespace App\Http\Controllers\Fontend;

use App\Banner;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $product;
    private $slider;
    private $category;
    private $banner;

    public function __construct(Product $product, Slider $slider, Category $category, Banner $banner)
    {
        $this->product = $product;
        $this->slider = $slider;
        $this->category = $category;
        $this->banner = $banner;
    }

    public function index()
    {
        //================ Sản phẩm nổi bật =============
        $productHighlight = $this->product->latest()
            ->where([
                ['highlight', 1],
                ['status', 1],
            ])->limit(15)->get();

        //============== Slider ===============
        $sliders = $this->slider->latest()->where('status', 1)->get();

        //=============== Sidebar - menu =================
        $menuCategoryProducts = $this->category
            ->where([
                ['parent_id', 0],
                ['status', 1]
            ])->get();

        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //============== Sản phẩm mới nhất ================
        $latestProduct = $this->product->where('status', 1)->latest()->limit(8)->get();

        //============= Sản phẩm bán chạy ===========
        // $productPay = $this->product
        //     ->where([
        //         ['pro_pay', '>=', 15],
        //         ['status', 1]
        //     ])->get()->random(7);

        $productPay = $this->product
            ->where([
                ['pro_pay', '>=', 15],
                ['status', 1]
            ])->limit(7)->get();

        //============= Phụ kiện ===========
        $categoryAccessories = $this->category->where('parent_id', 9)->get();

        $view = [
            'productHighlight' => $productHighlight,
            'sliders' => $sliders,
            'categorys' => $menuCategoryProducts,
            'banner' => $banner,
            'productPay' => $productPay,
            'latestProduct' => $latestProduct,
            'categoryAccessories' => $categoryAccessories
        ];

        return view('fontend.home', $view);
    }

    //================================= Chi tiết sản phẩm ======================
    public function show($category, $slug, $id)
    {
        $productDetail = $this->product->find($id);
        //Tăng số lượt xem sản phẩm đó
        $productDetail->product_view = $productDetail->product_view + 1;
        $productDetail->save();

        //=============== Sidebar - menu =================
        $menuCategoryProducts = $this->category->where('parent_id', 0)->get();

        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //===================== Meta seo ============
        $metaTitle = $productDetail->meta_title;
        $metaDesc = $productDetail->meta_desc;
        $metaKeyword = $productDetail->meta_keyword;

        //=============== Sản phẩm cùng chuyên mục =============
        $productCategory = $productDetail->category;   // từ id sản phẩm lấy ra danh mục của sản phẩm đấy
        $productSame = $productCategory->products()     //Từ danh mục lấy ra sản phẩm tương ứng
        ->where([
            ['id', '<>', $id],
            ['status', 1]
        ])->limit(7)->get();

        $view = [
            'productDetail' => $productDetail,
            'categorys' => $menuCategoryProducts,
            'banner' => $banner,
            'productSame' => $productSame,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeyword' => $metaKeyword
        ];

        return view('fontend.product.detail-product', $view);
    }

    public function searchProduct(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $keyword = $request->search;
        
        $productSearch = $this->product
            ->where('name', 'Like', "%$keyword%")
            ->where('status', 1)
            ->get();
        
        //=============== Sidebar - menu =================
        $menuCategoryProducts = $this->category->where('parent_id', 0)->get();

        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //======== Lọc ==========
        if ($request->price) {
            $price = $request->price;

            switch ($price) {
                case '1':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->where('price', '<', 500000)
                        ->get();
                    break;

                case '2':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [500000, 1000000])
                        ->get();
                    break;

                case '3':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [1000000, 3000000])
                        ->get();
                    break;

                case '4':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [3000000, 5000000])
                        ->get();
                    break;

                case '5':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [5000000, 7000000])
                        ->get();
                    break;

                case '6':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [7000000, 10000000])
                        ->get();
                    break;

                case '7':
                    $productSearch = $this->product
                        ->where([
                            ['name', 'Like', "%$keyword%"],
                            ['status', 1]
                        ])
                        ->where('price', '>', 10000000)
                        ->get();
                    break;
            }
        }

        $view = [
            'productSearch' => $productSearch,
            'categorys' => $menuCategoryProducts,
            'banner' => $banner
        ];

        return view('fontend.product.search', $view);
    }
}
