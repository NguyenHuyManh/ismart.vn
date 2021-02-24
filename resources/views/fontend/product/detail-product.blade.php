@extends('fontend.layout.matter')

@section('meta')
    <title>{{$metaTitle}}</title>
    <meta name="keywords" content="{{$metaKeyword}}"/>
    <meta name="description" content="{{$metaDesc}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <meta name="author" content="Cửa hàng di động bán lẻ kỹ thuật số ISMART STORE"/>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{ url('/') }}" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="{{route('category.product', ['slug' => $productDetail->category->slug, 'id' => $productDetail->category->id])}}"
                       title="">{{$productDetail->category->name}}</a>
                </li>
                <li>
                    {{$productDetail->name}}
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="section" id="detail-product-wp">
        <div class="section-detail clearfix">
            <div class="thumb-wp fl-left">
                <ul id="imageGallery">
                    <li data-thumb="{{url($productDetail->avatar)}}" data-src="{{url($productDetail->avatar)}}">
                        <img src="{{url($productDetail->avatar)}}" style="width: 350px; height: 350px" />
                    </li>
                    @foreach ($productDetail->imageDetails as $item)
                        <li data-thumb="{{url($item->image_detail)}}" data-src="{{url($item->image_detail)}}">
                            <img src="{{url($item->image_detail)}}" style="width: 350px; height: 350px"/>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="thumb-respon-wp fl-left">
                <img src="{{url($productDetail->avatar)}}" alt="">
            </div>
            <div class="info fl-right">
                <h3 class="product-name">{{$productDetail->name}}</h3>
                <div class="desc">
                    {!! $productDetail->content !!}
                </div>
              <!--   <div class="num-product">
                    <span class="title">Sản phẩm: </span>
                    @if($productDetail->amount > 0)
                        <span class="status">Còn hàng</span>
                    @else
                        <span class="status">Hết hàng</span>
                    @endif
                </div> -->
                @if ($productDetail->discount)
                    <p class="price-old">{{number_format($productDetail->price,'0',',','.')}}đ</p>
                    <p class="price-new">{{number_format($productDetail->discount,'0',',','.')}}đ</p>
                @else
                    <p class="price-new">{{number_format($productDetail->price,'0',',','.')}}đ</p>
                @endif
                <div id="num-order-wp">
                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                    <input type="text" name="num_order" value="1" id="num-order">
                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                    <p class="total_number_product">Có {{$productDetail->amount}} sản phẩm có sẵn</p>
                </div>
                <a href="{{route('cart.add', ['id' => $productDetail->id])}}" class="add-cart">Thêm giỏ hàng</a>
                {{-- <button type="submit" title="Mua ngay" class="buy-now">Mua ngay</button> --}}
            </div>
        </div>
    </div>
    <div class="section" id="post-product-wp">
        <div class="section-head">
            <h3 class="section-title">Mô tả sản phẩm</h3>
        </div>
        <div class="section-detail">
            {!! $productDetail->desc !!}
        </div>
    </div>
    @if ($productSame->count() > 0)
        <div class="section" id="same-category-wp">
            <div class="section-head">
                <h3 class="section-title">Cùng chuyên mục</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($productSame as $item)
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
    @endif
@endsection

@section('script')
    <script>
        $('.add-cart').on('click', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let num_order = $("#num-order").val();

            $.ajax({
                url: url,
                type: 'Get',
                dataType: 'json',
                data: {num_order: num_order},
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
