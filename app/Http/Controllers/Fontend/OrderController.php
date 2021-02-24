<?php

namespace App\Http\Controllers\Fontend;

use App\Order;
use App\Purchase_policy;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Order as MailOrder;
use App\Order_detail;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    private $order;
    private $order_detail;
    private $product;

    public function __construct(Order $order, Order_detail $order_detail, Product $product)
    {
        $this->order = $order;
        $this->order_detail = $order_detail;
        $this->product = $product;
    }

    public function checkOut()
    {

        return view('fontend.checkout');
    }

    public function saveOrder(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|',
                'phone' => 'required|numeric|digits:10|',
                'address' => 'required'
            ],
            [
                'name.required' => 'Vui lòng nhập tên của bạn!',
                'email.required' => 'Vui lòng nhật Email của bạn!!',
                'email.email' => 'Email không đúng định dạng!',
                'phone.required' => 'Số điện thoại không được để trống!',
                'phone.numeric' => 'Số điện thoại phải là chữ số!',
                'phone.digits' => 'Số điện thoại phải có 10 chữ số!',
                'address.required' => 'Vui lòng nhật địa chỉ của bạn!'
            ]
        );
        //Lưu thông tin đơn đặt hàng
        $code = "IS-" . strtoupper(Str::random(7));
        $dataOrder = [
            'code' => $code,
            'customer_id' => Auth::guard('customer')->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'total_money' => str_replace('.', '', Cart::total()),
            'type_payment' => $request->type_payment,
            'created_at' => now(),
        ];

        $orderId = $this->order->insertGetId($dataOrder);

        if ($orderId) {
            $orderDetail = Cart::content();

            //Lưu chi tiết đơn hàng
            foreach ($orderDetail as $key => $item) {
                $this->order_detail->create([
                    'order_id' => $orderId,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'product_qty' => $item->qty,
                    'product_price' => $item->price,
                ]);

                //Tăng số lượt mua sản phản phẩm đó
                $this->product->where('id', $item->id)->increment('pro_pay');

                //Trừ số lượng sản phẩm đó trong kho
                $this->product->where('id', $item->id)->decrement('amount', $item->qty);

                //Gửi email
                $shopping = [
                    'customer_name' => $request->name,
                    'created_at' => now(),
                    'customer_phone' => $request->phone,
                    'customer_address' => $request->address,
                    'type_payment' => $request->type_payment,
                    'detail_order' => $orderDetail
                ];

                Mail::to($request->email)->send(new MailOrder($shopping));
            }
        }

        //Xóa giở hàng
        Cart::destroy();

        return redirect()->route('user.purchase', ['id' => Auth::guard('customer')->user()->id])->with('success', 'Đặt hàng thành công!');
    }
}
