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
                            <option value="restore">Khôi phục</option>
                            <option value="forceDelete">Xóa vĩnh viễn</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
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
                                        <input type="checkbox" name="product_id[]" value="{{$product->id}}" class="check-childrent">
                                    </td>
                                    <td>{{$stt++}}</td>
                                    <td><img src="{{url($product->avatar)}}" class="img-thumbnail" width="70px"></td>
                                    <td>{{$product->name}}</td>
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
                                            <span class="badge badge-success"
                                                  style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</span>
                                        @else
                                            <span class="badge badge-danger"
                                                  style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->highlight == 1)
                                            <span class="badge badge-success"
                                                  style="padding: 10px 10px; font-size: 13px;border-radius: 1.25rem !important">Nổi bật</span>
                                        @else
                                            <span class="badge badge-danger"
                                                  style="padding: 10px 13px; font-size: 13px;border-radius: 1.25rem !important">Không</span>
                                        @endif

                                    </td>
                                    <td>
                                        @can('delete-product')
                                            <a href="{{route('admin.product.destroy', ['id' => $product->id])}}"
                                            class="btn btn-danger btn-sm rounded-0 text-white delete"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                 class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="10" style="text-align: center; color: red; font-weight: bold">Không có sản phẩm
                                nào!
                            </td>
                        @endif
                        </tbody>
                    </table>
                    {{$products->links()}}
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Xóa danh mục sản phẩm
        let url;
        $(".delete").on('click', function(event){
            event.preventDefault();
            url = $(this).attr('href');
            $("#delete-product").modal('show');
        });
        $('#ok-delete').on('click', function(){
            $.ajax({
                url: url,
                beforeSend: function(){
                    $('#ok-delete').text('Đang xóa');
                },
                success: function (result) {
                    if (result.message == 'ok') {
                        location.reload();
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
    </script>
@endsection
