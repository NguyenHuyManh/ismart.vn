<?php

namespace App\Http\Controllers\Backend;

use App\Customer;
use App\Order;
use App\Product;
use App\Post;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAdminRequest;
use App\User;
use App\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $order;
    private $product;
    private $post;
    private $admin;
    private $category;

    public function __construct(Order $order, Product $product, Post $post, Customer $customer, User $user, Category $category)
    {
        $this->order = $order;
        $this->product = $product;
        $this->post = $post;
        $this->customer = $customer;
        $this->user = $user;
        $this->category = $category;
    }

    public function index()
    {
        //========== Biểu đồ thống kê doanh thu =============
        //========Ngày hôm này
        $today = Carbon::today()->toDateTimeString(); //Bắt đầu từ 00:00:00
        $endToDay = Carbon::tomorrow()->toDateTimeString(); //Đầu giờ ngày mai 00:00:00
        $orderToDay = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$today, $endToDay])
            ->sum('total_money');

        //====== Tuần này
        $weekStartDate = Carbon::now()->startOfWeek()->toDateTimeString(); //Ngày đầu tiên của tuần
        $weekEndDate = Carbon::now()->endOfWeek()->toDateTimeString(); //Ngày cuối cùng của tuần
        $thisOrderWeek = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum('total_money');

        //===== Tuần trước
        $lastWeekStartDate = Carbon::now()->startOfWeek()->subDays(7)->toDateTimeString(); //Ngày đâu tiên tuần trước
        //Ngày cuối cùng tuần trước
        $lastWeekEndtDate = Carbon::now()->startOfWeek()->subDays(7)->addDays(7)->toDateTimeString();
        $lastOrderWeek = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$lastWeekStartDate, $lastWeekEndtDate])
            ->sum('total_money');

        //===== Tháng này
        $monthStartDate = Carbon::now()->startOfMonth()->toDateTimeString();
        $monthEndDate = Carbon::now()->endOfMonth()->toDateTimeString();
        $thisOrderMonth = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$monthStartDate, $monthEndDate])
            ->sum('total_money');

        //====== Tháng trước
        //Ngày đâu tiên đầu tháng trước
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->toDateTimeString();
        //Ngày cuối cùng tháng trước
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->toDateTimeString();
        $lastOrderMonth = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$lastMonthStartDate, $lastMonthEndDate])
            ->sum('total_money');

        //======== Cả năm
        $yearStartDate = Carbon::now()->startOfYear()->toDateTimeString();
        $yearEndDate = Carbon::now()->endOfYear()->toDateTimeString();
        $orderYear = $this->order
            ->where('status', 3)
            ->whereBetween('created_at', [$yearStartDate, $yearEndDate])
            ->sum('total_money');

        //========== Biểu đồ thống kê tình trạng đơn hàng - Tổng sp, bài viết, danh mục  =========
        // Đơn hàng
        $total_order_no_process = $this->order->where('status', 1)->count(); //Chưa xủ lý
        $total_order_processing = $this->order->where('status', 2)->count(); //Đang xử lí
        $total_order_finish = $this->order->where('status', 3)->count(); //Đã giao
        $total_order_canceled = $this->order->where('status', 4)->count(); //Đã hủy
        $total_order = $this->order->count(); //All
        $count_order = [$total_order_no_process, $total_order_processing, $total_order_finish, $total_order_canceled, $total_order];
        //Sản phẩm - bài viết - danh mục
        $total_product = $this->product->count(); //Tổng sản phẩm
        $total_post = $this->post->count(); //Tổng bài viết
        $total_category = $this->category->count();
        //Thành viên
        $total_admin = $this->user->count();
        //Khách hàng
        $total_customer = $this->customer->count();
        //Doanh thu
        $order = $this->order->select('total_money')->where('status', 3)->get();
        $total_revenue = 0;
        foreach ($order as $key => $item) {
            $total_revenue += $item->total_money;
        }

        //========= Đơn hàng mới ========
        $latestOrders = $this->order->latest()->where('status', 1)->paginate(5);

        //============= Top sản phẩm bán chạy ===========
        $topProductPay = $this->product
            ->where('pro_pay', '>=', 15)
            ->orderBy('pro_pay', 'DESC')->limit(10)->get();

        //============== Top sản phẩm xem nhiều nhất ========
        $topProductView = $this->product
            ->where('product_view', '>=', 100)
            ->orderBy('product_view', 'DESC')->limit(10)->get();

        //============== Top bài viết xem nhiều ==========
        $topPostView = $this->post
            ->where('post_view', '>=', 100)
            ->orderBy('post_view', 'DESC')->limit(10)->get();

        $dataView = [
            'latestOrders' => $latestOrders,
            'count_order' => $count_order,
            'total_revenue' => $total_revenue,
            'total_product' => $total_product,
            'total_post' => $total_post,
            'total_category' => $total_category,
            'total_admin' => $total_admin,
            'total_user' => $total_customer,
            'topProductPay' => $topProductPay,
            'topProductView' => $topProductView,
            'topPostView' => $topPostView,
            'orderToDay' => $orderToDay,
            'thisOrderWeek' => $thisOrderWeek,
            'lastOrderWeek' => $lastOrderWeek,
            'thisOrderMonth' => $thisOrderMonth,
            'lastOrderMonth' => $lastOrderMonth,
            'orderYear' => $orderYear
        ];

        return view('backend.dashboard.index', $dataView);
    }

    public function login()
    {
        return view('backend.auth.login');
    }

    public function checklogin(LoginAdminRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            return redirect('admin/dashboard');
        } else {
            return redirect()->back()->with('error', "Email hoặc mật khẩu không đúng!");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }

}
