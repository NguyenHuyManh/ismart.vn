<?php

namespace App\Http\Controllers\Fontend;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Post;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
    private $banner;
    private $product;
    private $post;

    public function __construct(Product $product, Banner $banner, Post $post)
    {
        $this->product = $product;
        $this->banner = $banner;
        $this->post = $post;
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

        //======================= Tin tức ================================
        $posts = $this->post->where('status', 1)->latest()->paginate(8);

        return view('fontend.post.index', compact('banner', 'productPay', 'posts'));
    }

    public function show($slug, $id)
    {
        //================ Banner ============
        $banner = $this->banner->where('status', 1)->first();

        //============= Sản phẩm bán chạy ===========
        $productPay = $this->product
            ->where([
                ['pro_pay', '>=', 15],
                ['status', 1]
            ])->limit(8)->get();

        //============ Detail post =============
        $detailPost = $this->post->find($id);
        //Tăng số lượt xem của bài viết đó
        $detailPost->post_view = $detailPost->post_view + 1;
        $detailPost->save();

        //========== Lấy thời gian tạo bài viết ======
        Carbon::setLocale('vi'); //chuyển sang tiếng việt
        $created_at = $detailPost->created_at;
        $time_now = Carbon::now();
        $date_time = $created_at->diffForHumans($time_now); //Format(vd:1 giờ trc)

        return view('fontend.post.detail', compact('banner', 'productPay', 'detailPost', 'date_time'));
    }

}
