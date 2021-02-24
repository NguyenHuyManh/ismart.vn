<?php

namespace App\Http\Controllers\Backend;

use App\Order;
use App\Order_detail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;


class AdminOrderController extends Controller
{
    private $order;
    private $order_detail;

    public function __construct(Order $order, Order_detail $order_detail)
    {
        $this->order = $order;
        $this->orderDetail = $order_detail;
    }

    public function index(Request $request)
    {
        //Thống kê
        $status = $request->input('status'); //Lấy url
        if ($status == 'finish') {
            $orders = $this->order->where('status', 3)->paginate(20);
        } elseif ($status == 'processing') {
            $orders = $this->order->where('status', 2)->paginate(20);
        } elseif ($status == 'no-process') {
            $orders = $this->order->where('status', 1)->paginate(20);
        } elseif ($status == 'cancel') {
            $orders = $this->order->where('status', 4)->paginate(20);
        } else {
            $keyword = '';
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $orders = $this->order
                ->latest()
                ->where('code', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->paginate(20);
        }

        //Đến tình trạng các đơn hàng
        $total_order = $this->order->count(); //All
        $total_order_finish = $this->order->where('status', 3)->count(); //Đã giao
        $total_order_processing = $this->order->where('status', 2)->count(); //Đang xử lí
        $total_order_no_process = $this->order->where('status', 1)->count(); //Chưa xử lí
        $total_order_canceled = $this->order->where('status', 4)->count(); //Đã hủy
        $count_order = [$total_order, $total_order_finish, $total_order_processing, $total_order_no_process, $total_order_canceled];

        return view('backend.order.index', compact('orders', 'count_order'));
    }

    public function show($id)
    {
        $order = $this->order->find($id);
        $orderDetail = $order->order_details; //Chi tiết đơn hàng của sản phẩm đó
        return view('backend.order.show', compact('order', 'orderDetail'));
    }

    //Cập nhật tình trạng đơn hàng
    public function update(Request $request, $id)
    {
        $this->order->where('id', $id)->update(['status' => $request->status]);
        return response()->json([
            'message' => 'Cập nhật thành công!',
            'status' => 'ok'
        ]);
        // return redirect()->route('admin.order.show', $id)->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        $order = $this->order->find($id)->delete();
        //Xóa chi tiết các đơn hàng có order_id = $id
        $this->orderDetail->where('order_id', $id)->delete();
        return response()->json([
            'order' => $order,
            'status' => true,
            'message' => 'ok'
        ]);
    }

    //============= In hóa đơn
    public function printOrder($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->printOderConvert($id));

        return $pdf->stream();
    }

    public function printOderConvert($id)
    {
        $orderItem = $this->order->find($id);
        $total_qty= 0;
        $orderDetail = $orderItem->order_details;
        foreach($orderDetail as $item)
        {
            $total_qty += $item->product_qty;
        }

        $output = '';
                $output .= '
                    <style>
                        body {
                            font-family: DejaVu Sans;
                            line-height: 1.5px;
                        }
                        .name-shop, .code, .total-money {
                            text-align: center;
                        }
                        .section1, .receiver, .content, .total-money {
                            border-top: 2px dotted;
                        }
                    </style>
                    <div class="container">
                        <h4 class="name-shop">ISMART</h4><br>
                        <p class="code">Mã đơn hàng: '. $orderItem->code .'</p>
                        <div class="section1">
                            <div class="sender">
                                <p>Từ:</p><br>
                                <p>'.$orderItem->name.'</p> 
                                <p>Địa chỉ: '.$orderItem->address.'</p>
                                <p>Số ĐT: '.$orderItem->phone.'</p>
                            </div>
                            <div class="receiver">
                                <p>Đến:</p><br>
                                <p>Huy Manh</p>
                                <p>Địa chỉ: Thôn vàng 4 - Cổ Bi - Gia Lâm - Hà Nội</p>
                                <p>Số ĐT: 0374469447</p>
                            </div>
                            <div class="content">
                                <p>Nội dung hàng (Tổng SL sản phẩm: '.$total_qty.')</p>';
                            $stt = 1;
                            foreach($orderDetail as $item){
                                $output .= '
                                <p>'.$stt++.'. '.$item->product_name.', SL: '.$item->product_qty.'</p>';
                            }         
                    $output .= '
                        </div>
                            <div class="total-money">
                                <p>Tiền thu người nhận:</p>
                                <h5>'.number_format($orderItem->total_money,'0',',','.').' VNĐ</h5>
                            </div>
                        </div>
	                </div>';
        return $output;
    }
}
