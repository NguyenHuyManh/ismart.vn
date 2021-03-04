@extends('backend.home')

@section('title')
    <title>Danh mục sản phẩm</title>
@endsection

@section('content')
    <!-- Modal Delete -->
    <div id="delete-category" class="modal fade" role="dialog">
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
                <h5 class="m-0 ">Danh mục sản phẩm</h5>
            </div>
            @if (session('status'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ url('admin/category/action') }}">
                    <div class="form-action form-inline add-category">
                        @can('add-category')
                            <a href="{{route('admin.category.create')}}" class="btn btn-primary" role="button">Thêm mới
                                <i
                                    class="fas fa-plus"></i></a>
                        @endcan
                    </div>
                    <table class="table table-hover table-checkall">
                        <thead>
                        <tr>
                            <th scope="col">Stt</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Title seo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @php
                            $stt = 1;
                        @endphp
                        @foreach ($categorys as $category)
                            <tr class="">
                                <td>{{$stt++}}</td>
                                <td>{{ str_repeat('|---', $category->level) . $category->name }}</td>
                                <td style="width:400px">{{$category->meta_title}}</td>
                                <td>
                                    <span>
                                        <i class="far fa-clock"></i> {{$category->created_at->format('d-m-Y')}}
                                    </span>
                                </td>
                                <td>
                                    @if ($category->status == 1)
                                        <a href="{{ route('admin.category.update_status', ['id' => $category->id]) }}"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển
                                            thị</a>
                                    @else
                                        <a href="{{ route('admin.category.update_status', ['id' => $category->id]) }}"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>
                                    @endif
                                </td>
                                <td>
                                    @can('edit-category')
                                        <a href="{{route('admin.category.edit',['id' => $category->id])}}"
                                           class="btn btn-success btn-sm rounded text-white" type="button"
                                           data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>  
                                        </a>
                                    @endcan
                                    @can('delete-category')
                                        <a href="{{route('admin.category.destroy',['id' => $category->id])}}"
                                           class="btn btn-danger btn-sm rounded text-white delete"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Delete">
                                           <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
            $("#delete-category").modal('show');
        });
        $('#ok-delete').on('click', function () {
            $.ajax({
                url: url,
                success: function (result) {
                    if (result.status == false) {
                        $("#delete-category").modal('hide');
                        Swal.fire(result.message);
                    } else {
                        location.reload();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Cập nhật trạng thái
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
    </script>
@endsection

