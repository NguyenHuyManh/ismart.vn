@extends('fontend.layout.matter')

@section('meta')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
    <meta name="keywords"
          content="ISMART, ismart, điện thoại di động, dtdd, smartphone, tablet, máy tính bảng, laptop, máy tính xách tay, phụ kiện, smartwatch, tin công nghệ"/>
    <meta name="description"
          content="Hệ thống bán lẻ điện thoại di động, smartphone, máy tính bảng, tablet, laptop, phụ kiện, smartwatch, giá tốt, dịch vụ khách hàng được yêu thích nhất VN"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <meta name="author" content="Cửa hàng di động bán lẻ kỹ thuật số ISMART STORE"/>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    Tìm kiếm
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="section" id="list-product-wp">
        <div class="section-head clearfix">
            <p style="font-size: 18px">Tìm thấy {{$productSearch->count()}} sản phẩm!</p>
            {{--            <h3 class="section-title fl-left">Tìm kiếm với từ khóa: {{ Request::get('search') }}</h3>--}}
        </div>
        <div class="section-detail">
            <ul class="list-item clearfix">
                @foreach ($productSearch as $item)
                    <li>
                        <a href="{{route('product.detail', ['category' => $item->category->slug, 'slug' => $item->slug, 'id' => $item->id])}}"
                           title="" class="thumb">
                            <img src="{{url($item->avatar)}}" style="height: 130px">
                        </a>
                        <a href="{{route('product.detail', ['category' => $item->category->slug, 'slug' => $item->slug, 'id' => $item->id])}}"
                           title="" class="product-name">{{$item->name}}</a>
                        <div class="price">
                            @if($item->discount)
                                <span class="new">{{number_format($item->discount,'0',',','.')}}đ</span>
                                <span class="old">{{number_format($item->price,'0',',','.')}}đ</span>
                            @else
                                <span class="new">{{number_format($item->price,'0',',','.')}}đ</span>
                            @endif
                        </div>
                        <div class="action clearfix">
                            <a href="{{route('cart.add', ['id' => $item->id])}}" title="Thêm giỏ hàng"
                               class="add-cart fl-left">Thêm giỏ hàng</a>
                            <a href="{{route('cart.buy_now', ['id' => $item->id])}}" title="Mua ngay"
                               class="buy-now fl-right">Mua ngay</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('filter')
    @include('fontend.elements.filter')
@endsection

@section('script')
    <script>
        $('.add-cart').on('click', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'Get',
                dataType: 'json',
                success: function (result) {
                    if (result.status == 'error') {
                        window.location.href = "{{ route('user.login') }}";
                    } else if (result.status == false) {
                        Swal.fire({
                            icon: 'warning',
                            title: result.message,
                            timer: 3000
                        })
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: result.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $("#cart-wp #num").text(result.number_total);
                        $("#cart-wp #dropdown").html(result.dropdown_cart);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
