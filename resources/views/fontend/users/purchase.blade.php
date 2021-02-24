@extends('fontend.layout.account')

@section('title')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
@endsection

@section('content')
<div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
    <div class="section" id="my-account-wp">
        <div class="section-head clearfix">
            <p class="my-account-section-title">Đơn hàng của tôi</p>
            <p>Danh sách đơn hàng đã mua.</p>
        </div>
        <div class="section-detail">
            <div class="my-account-profile">
                @if ($orders->count() > 0)
                <table class="table table-bordered purchase">
                    <thead>
                        <tr>
                            <th>Đơn hàng</th>
                            <th>Ngày mua</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng đơn hàng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                        <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->created_at->format('h:i d/m/Y') }}</td>
                            <td>{{ number_format($item->total_money, 0, ',', '.') }}đ</td>
                            <td class="text-primary">
                                @if ($item->status == 1)
                                    <span class="status-order">Chờ tiếp nhận</span>
                                @elseif($item->status == 2)
                                    <span class="status-order">Đang xử lý</span>
                                @elseif($item->status == 3)
                                    <span class="status-order">Đã giao</span>
                                @else
                                    <span class="status-order">Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.view_order', ['id' => $item->id]) }}">Xem đơn hàng</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
                @else
                <div class="cart-empety">
                    <p class="notification">Bạn chưa có đơn hàng nào!</p>
                    <p style="margin-bottom: 10px"><img class="img-fluid d-inline-block" src="{{asset('fontend/public/images/shopping-cart.png')}}" alt="" style="width:75px;height:71px; display: inline;"></p>
                    {{-- <p><i class="fa fa-cart-plus" aria-hidden="true"></i></p> --}}
                    <p><a href="{{url('/')}}" class="btn btn-danger" role="button" style="padding: 10px">Tiếp tục mua sắm</a></p>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection

