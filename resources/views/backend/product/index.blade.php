@extends('backend.home')

@section('title')
    <title>Danh sách sản phẩm</title>
@endsection

@section('content')
    <!-- Modal Delete -->
    <div id="delete-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-warning" style="padding: 10px">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center font-weight-bold">
                    <p style="margin: 5px">Bạn có chắc muốn xóa?</p>
                </div>
                <div class="modal-footer" style="padding: 10px">
                    <button type="submit" class="btn btn-primary" id="ok-delete">Xóa</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete -->
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" name="keyword" id="myInput"
                               placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <div class="analytic">
                    <a href="{{route('admin.product.index')}}" class="btn btn-primary">Tất cả <span class="text-primary badge badge-pill bg-white">{{$count[0]}}</span></a>
                    <a href="{{route('admin.product.trashed')}}" class="btn btn-info">Thùng rác <span class="text-info badge badge-pill bg-white">{{$count[1]}}</span></a>
                </div>
                <form action="{{ url('admin/product/action') }}">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="action">
                            <option>Chọn</option>
                            <option value="destroy">Xóa tạm thời</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        @can('add-product')
                            <a href="{{route('admin.product.create')}}" class="btn btn-primary add" role="button">Thêm
                                mới
                                <i class="fas fa-plus"></i></a>
                        @endcan
                    </div>

                    <div id="paginate-ajax">
                        <table class="table table-hover table-checkall">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <input class="checkall" type="checkbox">
                                </th>
                                <th scope="col">Stt</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Nổi bật</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @if ($products->count() > 0)
                                @php
                                    $stt = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" name="product_id[]" value="{{$product->id}}"
                                                   class="check-childrent">
                                        </td>
                                        <td>{{$stt++}}</td>
                                        <td><img src="{{url($product->avatar)}}" class="img-thumbnail" width="70px">
                                        </td>
                                        <td style="width: 200px">{{$product->name}}</td>
                                        @if ($product->discount)
                                            <td>{{number_format($product->discount,0,',','.')}}₫</td>
                                        @else
                                            <td>{{number_format($product->price,0,',','.')}}₫</td>
                                        @endif
                                        <td>{{$product->category->name}}</td>
                                        <td>
                                            <span><i class="fas fa-user"></i> {{$product->user->name}}</span><br>
                                            <span><i class="far fa-clock"></i> {{$product->created_at->format('H:i d-m-Y')}}</span>
                                        </td>
                                        <td>
                                            @if ($product->status == 1)
                                                <a href="{{ route('admin.product.update_status', ['id' => $product->id]) }}"
                                                   class="badge badge-success update-status" data-status="show"
                                                   style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển
                                                    thị</a>
                                            @else
                                                <a href="{{ route('admin.product.update_status', ['id' => $product->id]) }}"
                                                   class="badge badge-danger update-status" data-status="hiden"
                                                   style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->highlight == 1)
                                                <a href="{{ route('admin.product.update_highlight', ['id' => $product->id]) }}"
                                                   class="badge badge-success update-highlight" data-type_highlight="yes"
                                                   style="padding: 10px 10px; font-size: 13px;border-radius: 1.25rem !important">Nổi
                                                    bật</a>
                                            @else
                                                <a href="{{ route('admin.product.update_highlight', ['id' => $product->id]) }}"
                                                   class="badge badge-danger update-highlight" data-type_highlight="no"
                                                   style="padding: 10px 13px; font-size: 13px;border-radius: 1.25rem !important">Không</a>
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{route('product.detail', ['category' => $product->category->slug, 'slug' => $product->slug, 'id' => $product->id])}}"
                                               class="btn btn-primary btn-sm rounded text-white" type="button"
                                               data-toggle="tooltip" data-placement="top" title="Xem" target="_blank"><i
                                                    class="far fa-eye"></i></a>
                                            @can('edit-product')
                                                <a href="{{route('admin.product.edit',['id' => $product->id])}}"
                                                   class="btn btn-success btn-sm rounded text-white" type="button"
                                                   data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endcan
                                            @can('delete-product')
                                                <a href="{{route('admin.product.destroy', ['id' => $product->id])}}"
                                                   class="btn btn-danger btn-sm rounded text-white delete"
                                                   data-toggle="tooltip" data-placement="top" title="Delete">
                                                   <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="10" style="text-align: center; color: red; font-weight: bold">Không có sản
                                    phẩm
                                    nào!
                                </td>
                            @endif
                            </tbody>
                        </table>
                        {{$products->links()}}
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Xóa danh mục sản phẩm
        let url;
        $(".delete").on('click', function (event) {
            event.preventDefault();
            url = $(this).attr('href');
            $("#delete-product").modal('show');
        });
        $('#ok-delete').on('click', function () {
            $.ajax({
                url: url,
                beforeSend: function () {
                    $('#ok-delete').text('Đang xóa');
                },
                success: function (result) {
                    if (result.message == 'ok') {
                        location.reload();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Cập nhật trạng thái ẩn-hiện
        $(document).on('click', '.update-status', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let status = $(this).attr('data-status');
            let thisUpdate = $(this);

            $.ajax({
                url: url,
                type: 'Get',
                data: {status: status},
                dataType: 'json',
                success: function (result) {
                    thisUpdate.parent().html(result.html);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Cập nhật highlight
        $(document).on('click', '.update-highlight', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let typeHighLight = $(this).attr('data-type_highlight');
            let thisUpdate = $(this);

            $.ajax({
                url: url,
                type: 'Get',
                data: {highlight: typeHighLight},
                dataType: 'json',
                success: function (result) {
                    thisUpdate.parent().html(result.html);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>

    <!--     <script>
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $.ajax({
                url: "{{ route('admin.product.paginate_ajax') }}",
                data: {page: page},
                success: function (data) {
                    $('#paginate-ajax').html(data);
                }
            });
        });
    </script> -->
@endsection
