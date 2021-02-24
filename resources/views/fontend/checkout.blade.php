@extends('fontend.layout.checkout')

@section('title')
    <title>Thanh toán</title>
@endsection

@section('breadcrumb')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ url('/') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        Thanh toán
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('order.save') }}">
        @csrf
        <div class="section" id="customer-info-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin khách hàng</h1>
            </div>
            <div class="section-detail">
                <div class="form-row clearfix">
                    <div class="form-col fl-left">
                        <label for="fullname">Họ tên</label>
                        <input type="text" name="name" id="fullname"
                               value="@if(Auth::guard('customer')->check()) {{Auth::guard('customer')->user()->name }} @endif">
                        @error('name')
                        <div class="alert alert-danger"
                             style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-col fl-right">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                               value="@if(Auth::guard('customer')->check()) {{Auth::guard('customer')->user()->email }} @endif">
                        @error('email')
                        <div class="alert alert-danger"
                             style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row clearfix">
                    <div class="form-col fl-left">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" id="address"
                               value="@if(Auth::guard('customer')->check()) {{Auth::guard('customer')->user()->address }} @endif">
                        @error('address')
                        <div class="alert alert-danger"
                             style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-col fl-right">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" name="phone" id="phone"
                               value="@if(Auth::guard('customer')->check()) {{Auth::guard('customer')->user()->phone }} @endif">
                        @error('phone')
                        <div class="alert alert-danger"
                             style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label for="notes">Ghi chú</label>
                        <textarea name="note"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="section" id="order-review-wp">
            <div class="section-head">
                <h1 class="section-title">Thông tin đơn hàng</h1>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                    <tr>
                        <td>Sản phẩm</td>
                        <td>Tổng</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (Cart::content() as $item)
                        <tr class="cart-item">
                            <td class="product-name">
                                {{ $item->name }}<strong class="product-quantity">x {{ $item->qty }}</strong>
                            </td>
                            <td class="product-total">{{ number_format($item->price, 0, ',', '.')}}đ</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="order-total">
                        <td>Tổng đơn hàng:</td>
                        <td><strong class="total-price">{{ Cart::total() }}đ</strong></td>
                    </tr>
                    </tfoot>
                </table>
                <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" checked id="direct-payment" name="type_payment" value="1">
                            <label for="direct-payment">Thanh toán tại nhà</label>
                        </li>
                        <li>
                            <input type="radio" id="payment-home" name="type_payment" value="2">
                            <label for="payment-home">Thanh toán online</label>
                        </li>
                    </ul>
                </div>
                <div class="place-order-wp clearfix">
                    <input type="submit" id="order-now" value="Đặt hàng">
                </div>
            </div>
        </div>
    </form>
@endsection
