@extends('backend.home')

@section('title')
    <title>Danh sách bài viết</title>
@endsection

@section('content')
    <!-- Modal Delete -->
    <div id="delete-post" class="modal fade" role="dialog">
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
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="">
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
                    <a href="{{route('admin.post.index')}}" class="btn btn-primary">Tất cả <span class="text-primary badge badge-pill bg-white">{{$count[0]}}</span></a>
                    <a href="{{route('admin.post.trashed')}}" class="btn btn-info">Thùng rác <span class="text-info badge badge-pill bg-white">{{$count[1]}}</span></a>
                </div>
                <form action="{{route('admin.post.action')}}">
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
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
                            <th scope="col" style="width: 280px">Tiêu đề</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                        @php
                            $stt = 1;
                        @endphp
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <input type="checkbox" name="post_id[]" value="{{$post->id}}" class="check-childrent">
                                </td>
                                <td scope="row">{{$stt++}}</td>
                                <td>
                                    @if($post->avatar)
                                        <img src="{{url($post->avatar)}}" class="img-thumbnail" style="width:150px">
                                    @endif
                                </td>
                                <td>
                                    {{$post->title}}
                                </td>
                                @if ($post->status == 1)
                                    <td>
                                            <span class="badge badge-success"
                                                  style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</span>
                                    </td>
                                @else
                                    <td>
                                            <span class="badge badge-danger"
                                                  style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</span>
                                    </td>
                                @endif
                                <td>
                                    <span><i class="fas fa-user"></i> {{$post->user->name}}</span><br>
                                    <span><i class="far fa-clock"></i> {{$post->created_at->format('H:i d-m-Y')}}</span>
                                </td>
                                <td>
                                    
                                        <a href="{{route('admin.post.destroy', ['id' => $post->id])}}"
                                           class="btn btn-danger btn-sm rounded delete" data-toggle="tooltip"
                                           data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i>
                                        </a>
                                    
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$posts->links()}}
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
            $("#delete-post").modal('show');
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
    </script>
@endsection
