@extends('fontend.layout.account')

@section('title')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
@endsection

@section('content')
    <div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
        <div class="section" id="my-account-wp">
            <div class="section-head clearfix">
                <p class="my-account-section-title">Chi tiết đơn hàng #{{ $orderDetail->code }}</p>
                <p>Ngày đặt hàng: {{ $orderDetail->created_at->format('h:i d/m/Y') }}</p>
            </div>
            <div class="section-detail">
                <div class="info-order">
                    <div class="receiver-address">
                        <div class="title-header text-uppercase">
                            <p>Địa chỉ người nhận</p>
                        </div>
                        <div class="detail-content">
                            <div class="">
                                <p class="text-uppercase" style="font-size: 17px">{{ $orderDetail->name }}</p>
                                <p>Địa chỉ: {{ $orderDetail->address }}</p>
                                <p>Điện thoại: {{ $orderDetail->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="note">
                        <div class="title-header text-uppercase">
                            <p>Ghi chú</p>
                        </div>
                        <div class="detail-content">
                            <div class="">
                                <p>{{ $orderDetail->note }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="type-payment">
                        <div class="title-header text-uppercase">
                            <p>Hình thức thanh toán</p>
                        </div>
                        <div class="detail-content">
                            <div class="">
                                <p>{{ $orderDetail->type_payment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-order">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Ảnh sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($orderDetail->order_details as $item)
                            @php
                                $total += $item->product_price * $item->product_qty;
                                $itemProduct = $item->product()->first();
                                $categoryProduct = $itemProduct->category()->first();
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('product.detail', ['category' => $categoryProduct->slug, 'slug' => $item->product->slug, 'id' => $item->product->id ]) }}"
                                       target="_blank">
                                        <img src="{{ url($item->product->avatar) }}" class="img-thumbnail"
                                             width="100px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('product.detail', ['category' => $categoryProduct->slug, 'slug' => $item->product->slug, 'id' => $item->product->id ]) }}"
                                       target="_blank">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td>{{ number_format($item->product_price, 0, ',', '.') }}đ</td>
                                <td>{{ $item->product_qty }}</td>
                                <td>{{ number_format($item->product_price * $item->product_qty, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <p class="pull-right" style="font-size: 18px; margin-top: 20px">Tổng
                                    cộng: {{ number_format($total, 0, ',', '.') }}đ</p>
                            </td>
                        </tr>
                       
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

