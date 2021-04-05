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
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    {{$categoryName->name}}
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="section" id="list-product-wp">
        <div class="section-head clearfix">
            <h3 class="section-title fl-left">{{$categoryName->name}}</h3>
            <div class="filter-wp fl-right">
                {{--                <p class="desc">Có {{$productOfCategorys->count()}} sản phẩm</p>--}}
                {{--                <p class="desc">Hiển thị {{$count[0]}} trên {{$count[1]}} sản phẩm</p>--}}
                {{--                <div class="form-filter">--}}
                {{--                    <form method="POST" action="">--}}
                {{--                        <select name="select">--}}
                {{--                            <option value="0">Sắp xếp</option>--}}
                {{--                            <option value="desc">Giá cao xuống thấp</option>--}}
                {{--                            <option value="asc">Giá thấp lên cao</option>--}}
                {{--                        </select>--}}
                {{--                        <button type="submit" class="">Lọc</button>--}}
                {{--                    </form>--}}
                {{--                </div>--}}
            </div>
        </div>
        <div class="section-detail">
            <ul class="list-item clearfix">
                @foreach ($productOfCategorys as $item)
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
    <div class="section" id="paging-wp">
        {{$productOfCategorys->links()}}
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
                            showConfirmButton: true,
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
