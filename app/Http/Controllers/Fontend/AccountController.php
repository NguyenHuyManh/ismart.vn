<?php

namespace App\Http\Controllers\Fontend;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\Purchase_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $customer;
    private $order;

    public function __construct(Customer $customer, Order $order)
    {
        $this->customer = $customer;
        $this->order = $order;
    }

    public function userInfo($id)
    {
        $userInfo = $this->customer->find($id);

        return view('fontend.users.account', compact('userInfo'));
    }

    //===== Cập nhật thông tin tài khoản
    public function updateAccountInfo(Request $request, $id)
    {
        $user = $this->customer->find($id);
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:10',
            ],
            [
                'name.required' => 'Họ tên không được để trống!',
                'email.required' => 'Email không được để trống!',
                'email.email' => 'Email không đúng định dạng!',
                'phone.required' => 'Số điện thoại không được để trống!',
                'phone.numeric' => 'Số điện thoại phải là chữ số!',
                'phone.digits' => 'Số điện thoại phải có 10 chữ số!',
            ]
        );
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->birth_day = $request->birth_day;
        $user->save();
        return back()->with('success', 'Cập nhật thông tin!');
    }

    //==== Danh sách đơn hàng đã mua
    public function purchase($id)
    {
        $orders = $this->customer->find($id)->orders()->latest()->paginate(20);

        return view('fontend.users.purchase', compact('orders'));
    }

    //==== Xem chi tiết đơn hàng
    public function viewOrder($id)
    {
        $orderDetail = $this->order->find($id);

        //============ Chính sách mua hàng =========
        $purchasePolicy = Purchase_policy::where('status', 1)->get();

        return view('fontend.users.view_order', compact('orderDetail', 'purchasePolicy'));
    }

    //==== Thay đổi mật khẩu
    public function changePassword($id)
    {
        $customer = $this->customer->find($id);

        return view('fontend.users.change_password', compact('customer'));
    }

    public function saveChangePassword(Request $request, $id)
    {
        $customer = $this->customer->find($id);
        $request->validate(
            [
                'password' => 'required',
                'password_confirm' => 'required|same:password',
            ],
            [
                'password.required' => 'Vui lòng nhập mật khẩu mới!',
                'password_confirm.required' => 'Vui lòng nhập lại mật khẩu mới!',
                'password_confirm.same' => 'Xác nhận mật khẩu không đúng!',
            ]
        );
        $customer->password = Hash::make($request->password);
        $customer->save();

        return back()->with('success', 'Thay đổi thành công!');
    }
}
