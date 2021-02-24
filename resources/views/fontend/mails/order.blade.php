<div style="padding:30px;background-color:#e6e7e8">
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:20px;font-weight:600;margin-top:0;;font-weight:bold">Cảm ơn quý khách {{ $customer_name }} đã đặt hàng tại ISMART
    </p>
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:18px;font-weight:600;margin-top:0">Đơn hàng được đặt ngày {{ $created_at->format('d/m/Y') }}</p>
    <hr>
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:18px;font-weight:600;text-transform: uppercase;">Thông tin khách hàng:</p>
    <p style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;font-size:14px">Họ tên: {{ $customer_name }}.</p>
    <p style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;font-size:14px">Số điện thoại: {{ $customer_phone }}.</p>
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:14px;font-weight:400">Địa chỉ người nhận: {{ $customer_address }}.</p>
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:14px;font-weight:400">Hình thức thanh toán: {{ $type_payment == 1 ? 'Thanh toán tại nhà' : 'Thanh toán online' }}.</p>
    <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:18px;font-weight:600;margin-top:0;text-transform: uppercase;">Chi tiết đơn hàng</p>
    <table style="width:100%;margin-bottom:10px" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;padding:5px 10px;font-size:14px;text-align:center;border-bottom:1px solid #231f20;text-transform:uppercase">STT</td>
                <td style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;text-align:left;padding:5px 10px;font-size:14px;border-bottom:1px solid #231f20;text-transform:uppercase">TÊN SẢN PHẨM</td>
                <td style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;padding:5px 10px;font-size:14px;text-align:center;border-bottom:1px solid #231f20;text-transform:uppercase">ĐƠN GIÁ(VNĐ)</td>
                <td style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;padding:5px 10px;font-size:14px;text-align:center;border-bottom:1px solid #231f20;text-transform:uppercase">SỐ LƯỢNG</td>
                <td style="font-family:'Open Sans',sans-serif;font-weight:400;color:#231f20;padding:5px 10px;font-size:14px;text-align:center;border-bottom:1px solid #231f20;text-transform:uppercase">THÀNH TIỀN(VNĐ)</td>
            </tr>
        </thead>
        <tbody>
            @php
                $stt = 1;
                $total_money = 0;
            @endphp
            @foreach($detail_order as $key => $item)
                @php
                    $total_money += $item->total;
                @endphp
                <tr>
                    <td style="padding:5px 10px;font-size:14px;text-align:center">{{ $stt++ }}</td>
                    <td style="text-align:left;padding:5px 10px;font-size:14px">{{ $item->name }}</td>
                    <td style="padding:5px 10px;font-size:14px;text-align:center">{{ number_format($item->price,'0',',','.') }}</td>
                    <td style="padding:5px 10px;font-size:14px;text-align:center">{{ $item->qty }}</td>
                    <td style="padding:5px 10px;font-size:14px;text-align:center">{{ number_format($item->total,'0',',','.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="text-align:right;padding:5px 10px;font-size:14px" colspan="4">Phí vận chuyển</td>
                <td style="text-align:right;padding:5px 10px;font-size:14px">0</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;padding:5px 10px;font-size:14px;font-weight:bold">Tổng giá trị đơn hàng</td>
                <td style="text-align:right;padding:5px 10px;font-size:14px;font-weight:bold">{{ number_format($total_money,'0',',','.') }}VNĐ</td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 20px">
        <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:14px;font-weight:400">Đây là email tự động, xin vui lòng không phản hồi vào email này.</p>
        <p style="font-family:'Open Sans',sans-serif;color:#231f20;font-size:14px;font-weight:400">Nếu bạn cần hỗ trợ vui lòng gọi: <strong>0374469446</strong>.</p>
    </div>
    
</div>