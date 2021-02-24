@extends('backend.home')

@section('title')
    <title>Quản trị ISMART</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admin/css/morris.css')}}">
@endsection

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">THÀNH VIÊN</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $total_admin }}</h5>
                        <p class="card-text">Quản trị hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count_order[4]}}</h5>
                        <p class="card-text">Tổng số đơn hàng</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH THU</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($total_revenue, '0', ',', '.') }} VNĐ</h5>
                        <p class="card-text">Tổng doanh thu hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">KHÁCH HÀNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $total_user }}</h5>
                        <p class="card-text">Tổng số khách hàng đăng kí</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">BIỂU ĐỒ THỐNG KÊ DOANH THU</div>
                    <div class="card-body">
                        <div class="mx-auto">
                            <div id="morris-static" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Tình trạng đơn hàng - Tổng sản phẩm bài viết danh mục--}}
        <div class="row mb-3">
            <div class="col-7">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">THỐNG KÊ TÌNH TRẠNG ĐƠN HÀNG</div>
                    <div class="card-body">
                        <div class="mx-auto">
                            <div id="morris-order" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">THỐNG KÊ TỔNG SẢN PHẨM - BÀI VIẾT - DANH MỤC
                    </div>
                    <div class="card-body">
                        <div class="mx-auto">
                            <div id="morris-product-post" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Tình trạng đơn hàng - Tổng sản phẩm bài viết danh mục--}}
        {{--Đơn hàng mới--}}
        <div class="row mb-3">
            <div class="col-7">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">
                        ĐƠN HÀNG MỚI
                    </div>
                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thông tin</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @foreach( $latestOrders as $item)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>
                                        <ul>
                                            <li>{{ $item->name }}</li>
                                            <li>{{ $item->phone }}</li>
                                            @if(!empty($item->note))
                                                <li>{{ $item->note }}</li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td>{{ number_format($item->total_money, '0', ',', '.') }}₫</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge badge-secondary">Chưa xử lý</span>
                                        @elseif ($item->status == 2)
                                            <span class="badge badge-warning">Đang xử lý</span>
                                        @else
                                            <span class="badge badge-success">Đã giao</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('H:i d-m-Y') }}</td>
                                    <td>
                                        <a href="{{route('admin.order.show', ['id' => $item->id])}}"
                                           class="btn btn-primary btn-sm rounded-0 text-white" type="button"
                                           data-toggle="tooltip" data-placement="top" title="Xem"><i
                                                class="far fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $latestOrders->links() }}
                    </div>
                </div>
            </div>
            {{--Top sản phẩm bán chạy--}}
            <div class="col-5">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">TOP SẢN PHẨM BÁN CHẠY</div>
                    <div class="card-body">
                        <ul class="top-product-pay">
                            @foreach ($topProductPay as $item)
                                <li>
                                    <div class="product-image">
                                        <a href="{{ route('product.detail', ['category'=>$item->category->slug, 'slug'=>$item->slug, 'id'=>$item->id]) }}" target="_blank">
                                            <img src="{{ url($item->avatar) }}" style="width: 60px" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <span class="text-primary">{{ $item->pro_pay }} lượt mua</span><br>
                                        <a href="{{ route('product.detail', ['category'=>$item->category->slug, 'slug'=>$item->slug, 'id'=>$item->id]) }}" target="_blank" class="product-name">{{ $item->name }}</a>
                                    </div>
                                    <span class="badge badge-warning product-price">{{ number_format($item->price) }}₫</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{--Sản phẩm xem nhiều nhất - bài viết xem nhiều nhất--}}
        <div class="row">
            {{--Bài viết xem nhiều--}}
            <div class="col-7">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">TOP BÀI VIẾT XEM NHIỀU</div>
                    <div class="card-body">
                        <ul class="top-product-view">
                            @foreach ($topPostView as $item)
                                <li>
                                    <div class="product-image">
                                        <a href="{{ route('post.show',['slug' => $item->slug, 'id' => $item->id]) }}" target="_blank">
                                            <img src="{{ url($item->avatar) }}" style="width: 80px" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <span class="text-primary">{{ $item->post_view }} lượt xem</span><br>
                                        <a href="{{ route('post.show',['slug' => $item->slug, 'id' => $item->id]) }}" target="_blank" class="product-name">{{ $item->title }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Top sản phẩm xem nhiều  --}}
            <div class="col-5">
                <div class="card">
                    <div class="card-header font-weight-bold text-center">TOP SẢN PHẨM XEM NHIỀU</div>
                    <div class="card-body">
                        <ul class="top-product-pay">
                            @foreach ($topProductView as $item)
                                <li>
                                    <div class="product-image">
                                        <a href="{{ route('product.detail', ['category'=>$item->category->slug, 'slug'=>$item->slug, 'id'=>$item->id]) }}" target="_blank">
                                            <img src="{{ url($item->avatar) }}" style="width: 60px" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <span class="text-primary">{{ $item->product_view }} lượt xem</span><br>
                                        <a href="{{ route('product.detail', ['category'=>$item->category->slug, 'slug'=>$item->slug, 'id'=>$item->id]) }}" target="_blank" class="product-name">{{ $item->name }}</a>
                                    </div>
                                    <span class="badge badge-warning product-price">{{ number_format($item->price) }}₫</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        new Morris.Donut({
            element: 'morris-order',
            colors: ["#4f61a1", "#dc3545", "#007bff", "#ee4000"],
            data: [
                {label: 'Đã giao', value: {{ $count_order[2] }} },
                {label: 'Chưa x.lý', value: {{ $count_order[0] }} },
                {label: 'Đang x.lý', value: {{ $count_order[1] }} },
                {label: 'Đã hủy', value: {{ $count_order[3] }} },
            ],
            labels: ['Value']
        });

        new Morris.Donut({
            element: 'morris-product-post',
            data: [
                {label: 'Sản phẩm', value: {{ $total_product }} },
                {label: 'Bài viết', value: {{ $total_post }} },
                {label: 'Danh mục', value: {{$total_category}} }
            ],
            labels: ['Value']
        });

        Morris.Bar({
        element: 'morris-static',
        gridTextSize: '14px',
        gridTextColor: 'black',
        data: [
            { y: 'Hôm nay', a: {{ $orderToDay }} },
            { y: 'Tuần này', a: {{ $thisOrderWeek }} },
            { y: 'Tuần trước', a: {{ $lastOrderWeek }} },
            { y: 'Tháng này', a: {{ $thisOrderMonth }} },
            { y: 'Tháng trước', a: {{ $lastOrderMonth }} },
            { y: 'Cả năm', a: {{ $orderYear }} }
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Doanh thu']
        });
    </script>
@endsection
