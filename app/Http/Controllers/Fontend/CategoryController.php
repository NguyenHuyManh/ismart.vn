<?php

namespace App\Http\Controllers\Fontend;

use App\Banner;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $product;
    private $category;
    private $banner;

    public function __construct(Product $product, Category $category, Banner $banner)
    {
        $this->product = $product;
        $this->category = $category;
        $this->banner = $banner;
    }

    //=========== Lấy ra danh sách sản phẩm thuộc danh mục
    public function index($slug, $id, Request $request)
    {
        //=============== Lấy ra các sản phẩm thuộc danh mục =============
        $productOfCategorys = $this->product
            ->where([
                ['category_id', $id],
                ['status', 1]
            ])->paginate(20);

        if ($request->price) {
            $price = $request->price;

            switch ($price) {
                case '1':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->where('price', '<', 500000)
                        ->paginate(20);
                    break;

                case '2':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [500000, 1000000])
                        ->paginate(20);
                    break;

                case '3':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [1000000, 3000000])
                        ->paginate(20);
                    break;

                case '4':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [3000000, 5000000])
                        ->paginate(20);
                    break;

                case '5':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [5000000, 7000000])
                        ->paginate(20);
                    break;

                case '6':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->whereBetween('price', [7000000, 10000000])
                        ->paginate(20);
                    break;

                case '7':
                    $productOfCategorys = $this->product
                        ->where([
                            ['category_id', $id],
                            ['status', 1]
                        ])
                        ->where('price', '>', 10000000)
                        ->paginate(20);
                    break;
            }
        }


        //=============== Sidebar - menu =================
        $menuCategoryProducts = $this->category
            ->where([
                ['parent_id', 0],
                ['status', 1]
            ])->get();

        //============== Lấy ra tên danh mục hiện hành =============
        $categoryName = $this->category->find($id);

        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //============== Đến số lượng sản phẩm có trên trang ==========
        //Tổng số lượng sản phẩm có trên trang hiện tại
//        $count_product = $this->product
//            ->where([
//                ['category_id', $id],
//                ['status', 1]
//            ])->paginate(20)->count();
//
//        //Tổng số lượng sản phẩm thuộc danh mục
//        $count_product_of_category = $this->product->where('category_id', $id)->count();
//        $count = [$count_product, $count_product_of_category];

        //===================== Meta seo ============
        $metaTitle = $categoryName->meta_title;
        $metaDesc = $categoryName->meta_desc;
        $metaKeyword = $categoryName->meta_keyword;



        $view = [
            'productOfCategorys' => $productOfCategorys,
            'categorys' => $menuCategoryProducts,
            'categoryName' => $categoryName,
            'banner' => $banner,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeyword' => $metaKeyword
        ];

        return view('fontend.product.category.category-product', $view);
    }
}
