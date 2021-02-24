@extends('fontend.layout.matter')

@section('meta')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
    <meta name="keywords" content="ISMART, ismart, điện thoại di động, dtdd, smartphone, tablet, máy tính bảng, laptop, máy tính xách tay, phụ kiện, smartwatch, tin công nghệ" />
    <meta name="description" content="Hệ thống bán lẻ điện thoại di động, smartphone, máy tính bảng, tablet, laptop, phụ kiện, smartwatch, giá tốt, dịch vụ khách hàng được yêu thích nhất VN" />
    <meta name="robots" content="INDEX,FOLLOW"/>
    <meta name="author" content="Cửa hàng di động bán lẻ kỹ thuật số ISMART STORE" />
@endsection

@section('content')
    <div class="section" id="slider-wp">
        <div class="section-detail">
            @foreach ($sliders as $slider)
                <div class="item">
                    <img src="{{url($slider->image)}}" alt="" style="height: 370px">
                </div>
            @endforeach
        </div>
    </div>
    <div class="section" id="support-wp">
        <div class="section-detail">
            <ul class="list-item clearfix">
                <li>
                    <div class="thumb">
                        <img src="{{asset('fontend/public/images/icon-1.png')}}">
                    </div>
                    <p class="title">Miễn phí vận chuyển</p>
                    <p class="desc">Tới tận tay khách hàng</p>
                </li>
                <li>
                    <div class="thumb">
                        <img src="{{asset('fontend/public/images/icon-2.png')}}">
                    </div>
                    <p class="title">Tư vấn 24/7</p>
                    <p class="desc">{{ $setting->phone }}</p>
                </li>
                <li>
                    <div class="thumb">
                        <img src="{{asset('fontend/public/images/icon-3.png')}}">
                    </div>
                    <p class="title">Tiết kiệm hơn</p>
                    <p class="desc">Với nhiều ưu đãi cực lớn</p>
                </li>
                <li>
                    <div class="thumb">
                        <img src="{{asset('fontend/public/images/icon-4.png')}}">
                    </div>
                    <p class="title">Thanh toán nhanh</p>
                    <p class="desc">Hỗ trợ nhiều hình thức</p>
                </li>
                <li>
                    <div class="thumb">
                        <img src="{{asset('fontend/public/images/icon-5.png')}}">
                    </div>
                    <p class="title">Đặt hàng online</p>
                    <p class="desc">Thao tác đơn giản</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="section" id="feature-product-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm nổi bật</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($productHighlight as $item)
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
                            <a href="{{route('cart.add', ['id' => $item->id])}}" title="" class="add-cart fl-left">Thêm
                                giỏ hàng</a>
                            <a href="{{route('cart.buy_now', ['id' => $item->id])}}" title="" class="buy-now fl-right">Mua ngay</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="list-product-wp">
        <div class="section-head">
            <h3 class="section-title name-category">Sản phẩm mới nhất</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item clearfix">
                @foreach ($latestProduct as $item)
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
                             <a href="{{route('cart.add', ['id' => $item->id])}}" title="" class="add-cart fl-left">Thêm
                                 giỏ hàng</a>
                             <a href="{{route('cart.buy_now', ['id' => $item->id])}}" title="" class="buy-now fl-right">Mua ngay</a>
                         </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="list-product-wp">
        <div class="section-head">
            <h3 class="section-title name-category">Phụ kiện chính hãng</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item clearfix">
                @foreach ($categoryAccessories as $categoryItem)
                    @foreach ($categoryItem->products as $item)
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
                             <a href="{{route('cart.add', ['id' => $item->id])}}" title="" class="add-cart fl-left">Thêm
                                 giỏ hàng</a>
                             <a href="{{route('cart.buy_now', ['id' => $item->id])}}" title="" class="buy-now fl-right">Mua ngay</a>
                         </div>
                    </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('sidebar-product-pay')
    @include('fontend.elements.sidebar-product-pay')
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
                            showConfirmButton: true,
                            timer: 2000
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
