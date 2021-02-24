@extends('fontend.layout.cart')

@section('title')
    <title>Giỏ hàng</title>
@endsection

@section('breadcrumb')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        Giỏ hàng
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (Cart::count() > 0)
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <form action="{{route('cart.update')}}" method="get">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Giá khuyến mại</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach (Cart::content() as $item)
                            <tr>
                                <td>
                                    <a href="{{route('product.detail', ['category' => $item->options->slug_category, 'slug' => $item->options->slug_product, 'id' => $item->id])}}"
                                       title="" class="thumb">
                                        <img src="{{url($item->options->avatar)}}" alt="">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('product.detail', ['category' => $item->options->slug_category, 'slug' => $item->options->slug_product, 'id' => $item->id])}}"
                                       title="" class="name-product">
                                        {{$item->name}}
                                    </a>
                                </td>
                                <td>{{number_format($item->options->price_old,'0',',','.')}}đ</td>
                                @if ($item->options->price_discount == 0)
                                    <td>0</td>
                                @else
                                    <td>{{number_format($item->price,'0',',','.')}}đ</td>
                                @endif
                                <td>
                                    <input type="number" min="1" name="qty[{{$item->rowId}}]"
                                           value="{{$item->qty}}" class="num-order" data-rowid="{{ $item->rowId }}">
                                </td>
                                <td id="sub-total-{{ $item->rowId }}">{{number_format($item->total,'0',',','.')}}đ</td>
                                <td>
                                    <a href="{{route('cart.remove', ['rowId' => $item->rowId])}}" title=""
                                       class="del-product"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span
                                            id="total-money">{{Cart::total()}}đ</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        {{--                                    <button type="submit" id="update-cart">Cập nhật giỏ hàng</button>--}}
                                        <a href="{{route('cart.destroy')}}" title="" id="update-cart">Xóa giỏ hàng</a>
                                        <a href="{{ route('order.checkout') }}" title="" id="checkout-cart">Thanh
                                            toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>“Xóa giỏ hàng“</span> để xóa tất cả sản phẩm có trong giỏ hàng. Nhấn vào <span>“Thanh toán“</span> để
                    hoàn tất mua hàng.</p>
                <a href="{{url('/')}}" title="" id="buy-more">Mua tiếp</a><br/>
            </div>
        </div>
    @else
        <div class="cart-empety">
            <p class="notification">Không có sản phẩm nào trong giỏ hàng!</p>
            <p style="margin-bottom: 10px"><img class="img-fluid d-inline-block"
                                                src="{{asset('fontend/public/images/shopping-cart.png')}}" alt=""
                                                style="width:75px;height:71px; display: inline;"></p>
            {{-- <p><i class="fa fa-cart-plus" aria-hidden="true"></i></p> --}}
            <p><a href="{{url('/')}}" class="btn btn-danger" role="button" style="padding: 10px">Tiếp tục mua sắm</a>
            </p>
        </div>
    @endif
@endsection

@section('script')
    <script>
        $('.num-order').change(function () {
            let rowId = $(this).attr("data-rowid");
            let qty = $(this).val();

            $.ajax({
                url: "{{ route('cart.update') }}",
                type: 'Get',
                dataType: 'json',
                data: {rowId: rowId, qty: qty},
                success: function (result) {
                    $("#sub-total-" + rowId).text(result.sub_total + "đ");
                    $("#total-money").text(result.total_price + "Đ");
                    $("#cart-wp #num").text(result.number_total);
                    $("#cart-wp #dropdown").html(result.dropdown_cart);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        //Xóa sản phẩm trong giở hàng
        $(".del-product").on('click', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let that = $(this);
            $.ajax({
                url: url,
                type: 'Get',
                dataType: 'json',
                success: function (result) {
                    that.parent().parent().hide(1000); //Ẩn đi sau 1s
                    $("#total-money").text(result.total_price + "Đ");
                    $("#cart-wp #num").text(result.number_total);
                    $("#cart-wp #dropdown").html(result.dropdown_cart);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
