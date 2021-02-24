@extends('backend.home')

@section('title')
    <title>Chi tiết đơn hàng</title>
@endsection

@section('content')
<div id="content" class="container-fluid">
    <div class="card border-0">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Thông tin đơn hàng</h5>
        </div>
        <div class="card-body pt-0" style="margin-left: 5px">
            <div class="form-group">
                <p><strong>Mã đơn hàng:</strong> {{ $order->code }}</p>
            </div>
            <div class="form-group">
                <p><strong>Tên khách hàng:</strong> {{ $order->customer->name }}</p>
            </div>
            <div class="form-group">
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            </div>
            <div class="form-group">
                <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>   
            </div>
            <div class="form-group">
                <p><strong>Nội dung:</strong> {{ $order->note }}</p>  
            </div>
            <div class="form-group">
                <p><strong>Thông tin vận chuyển:</strong> {{ $order->type_payment }}</p>
            </div>
            <div class="form-group">
                <h5 class="">Tình trạng đơn hàng:</h5> 
                    @csrf                    
                    <div class="form-action form-inline mt-3">
                        <select class="form-control bg-light text-black mr-1 change-status" name="status">
                            @if($order->status == 1)
                                <option selected value="1">Chưa xử lý</option>
                                <option value="2">Đang xử lý</option>
                                <option value="3">Đã giao</option>
                                <option value="4">Hủy</option>
                            @elseif($order->status == 2)
                                <option value="1">Chưa xử lý</option>
                                <option selected value="2">Đang xử lý</option>
                                <option value="3">Đã giao</option>
                                <option value="4">Hủy</option>
                            @elseif($order->status == 3)
                                <option value="1">Chưa xử lý</option>
                                <option value="2">Đang xử lý</option>
                                <option selected value="3">Đã giao</option>
                                <option value="4">Hủy</option>
                            @else
                                <option value="1">Chưa xử lý</option>
                                <option value="2">Đang xử lý</option>
                                <option value="3">Đã giao</option>
                                <option selected value="4">Hủy</option>
                            @endif
                        </select>
                        <button type="button" class="btn btn-primary update-order" data-url="{{ route('admin.order.update_status', ['id' => $order->id]) }}"">Cập nhật đơn hàng</button>
                        {{-- <input type="submit" class="btn btn-primary" value="Cập nhật đơn hàng"> --}}
                    </div>
            </div>
        </div>
    </div>
    <div class="card border-0">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Sản phẩm đơn hàng</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">Stt</th>
                        <th scope="col">ẢNH SẢN PHẨM</th>
                        <th scope="col">TÊN SẢN PHẨM</th>
                        <th scope="col">ĐƠN GIÁ</th>
                        <th scope="col">SỐ LƯỢNG</th>
                        <th scope="col">THÀNH TIỀN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stt = 1;
                        $total_qty = 0;
                    @endphp
                    @foreach($orderDetail as $key => $item)
                        @php
                            $sub_total = $item->product_price * $item->product_qty;
                            $qty = $item->product_qty;
                            $total_qty += $qty;
                            $itemProduct = $item->product()->first();
                            $categoryProduct = $itemProduct->category()->first();
                        @endphp
                        <tr>
                            <td scope="row">{{ $stt++ }}</td>
                            <td>
                                <a href="{{ route('product.detail', ['category' => $categoryProduct->slug, 'slug' => $item->product->slug, 'id' => $item->product->id ]) }}"
                                    target="_blank">
                                    <img width="80px" src="{{ url($item->product->avatar) }}" class="img-thumbnail">
                                </a>
                            </td>
                            <td>
                                <a  href="{{ route('product.detail', ['category' => $categoryProduct->slug, 'slug' => $item->product->slug, 'id' => $item->product->id ]) }}"
                                    target="_blank" class="pd-name">{{ $item->product_name }}</a>
                            </td>
                            <td>{{ number_format($item->product_price, '0', ',', '.') }}₫</td>
                            <td>{{ $item->product_qty }}</td>
                            <td>{{ number_format($sub_total, '0', ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card border-0">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0">Giá trị đơn hàng</h5>
        </div>
        <div class="card-body text-center">
            <div class="form-group">
                <p><strong>Tổng số lượng:</strong> {{ $total_qty }}</p>
            </div>
            <div class="form-group">
                <p><strong>Tổng đơn hàng:</strong> {{ number_format($order->total_money, '0', ',', '.') }}đ</p>
            </div>  
            <div class="form-group">
                <a class="btn btn-danger" target="_blank" href="{{ route('admin.order.print_order', ['id' => $order->id ])}}">In hóa đơn <i class="fas fa-print"></i></a>
                {{-- <button type="button" class="btn btn-danger">In hóa đơn <i class="fas fa-print"></i></button> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        let status = 0;
        $('.change-status').change(function(){
            status = $(this).val();
        });

        $('.update-order').on('click', function(){
           let url = $(this).attr('data-url');
           let _token = $('input[name=_token]').val();
           $.ajax({
                url: url,
                type: 'POST',
                data:{_token: _token, status: status},
                success: function(result){
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })
                }
           });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
@endsection