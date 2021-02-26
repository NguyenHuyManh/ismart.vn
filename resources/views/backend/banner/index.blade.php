@extends('backend.home')

@section('title')
    <title>Danh sách banner</title>
@endsection

@section('content')
    <!-- The Modal Edit -->
    <div class="modal" id="edit-banner">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật ảnh Banner</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="POST" id="update-banner" enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control-file" type="file" name="image" id="imgInp">
                        </div>
                        <div class="form-group">
                            <img src="" alt="" id="imgOut" class="img-thumbnail"
                                    style="width: 200px">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Trạng thái:</label>
                            <div class="form-check">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="form-check-input" id="update-status" name="status"
                                        value="1">
                                <label class="form-check-label" for="update-status">Hiển thị</label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Edit --}}
    <!-- The Modal Add -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm ảnh Banner</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('admin.banner.store')}}" method="POST" id="banner-validate"
                      enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control-file" type="file" name="image" id="imgInp2">
                            @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{asset('admin/images/images.png')}}" alt="" id="imgOut2" class="img-thumbnail"
                                 style="width: 200px">
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Trạng thái:</label>
                            <div class="form-check">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status"
                                       value="1">
                                <label class="form-check-label" for="exampleCheck1">Hiển thị</label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Add --}}
    <!-- Modal Delete -->
    <div id="delete-banner" class="modal fade" role="dialog">
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
    {{-- End Modal Delete --}}
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách banner</h5>
            </div>
            <div class="card-body">
                <div class="form-action form-inline py-3" style="margin-bottom: 20px">
                    @can('add-banner')
                        <button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#myModal">
                            Thêm mới <i class="fas fa-plus"></i>
                        </button>
                    @endcan
                </div>
                <table class="table table-hover table-checkall text-center">
                    <thead>
                    <tr>
                        <th scope="col">Stt</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($banners as $item)
                        <tr>
                            <td scope="row">{{$stt++}}</td>
                            <td><img src="{{url($item->image)}}" class="img-thumbnail" id="{{ $item->id }}" style="width: 200px">
                            </td>
                            <td>
                                @if ($item->status == 1)
                                    <a href="{{ route('admin.banner.update_status', ['id' => $item->id]) }}"
                                       class="badge badge-success update-status" data-status="show" 
                                       style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển
                                        thị</a>
                                @else
                                    <a href="{{ route('admin.banner.update_status', ['id' => $item->id]) }}"
                                       class="badge badge-danger update-status" data-status="hiden" 
                                       style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>
                                @endif
                            </td>
                            <td>
                                <span><i class="far fa-clock"></i> {{$item->created_at->format('m-d-Y')}}</span>
                            </td>
                            <td>
                                @can('edit-banner')
                                    <a href="{{route('admin.banner.edit', ['id' => $item->id])}}"
                                       class="btn btn-success btn-sm rounded-0 edit-banner" data-toggle="tooltip"
                                       data-placement="top" data-id="{{ $item->id }}"
                                       title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-banner')
                                    <a href="{{route('admin.banner.destroy', ['id' => $item->id])}}"
                                       class="btn btn-danger btn-sm rounded-0 delete" data-toggle="tooltip"
                                       data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            //Reset image befor add
            $('.add').on('click', function(){
                $('#imgInp2').val('');
                $('#exampleCheck1').prop("checked", false);
                $('#imgOut2').attr('src', 'http://localhost:8080/Laravel/ismart.vn/public/admin/images/images.png');
            });
            
            // Sửa banner
            $('.edit-banner').on('click', function(event){
                event.preventDefault();
                $('#imgInp').val('');
                let imgPath = $(this).parent().parent().find('.img-thumbnail').attr('src');
                let statusItem = $(this).parent().parent().find('.update-status').attr('data-status');
                let bannerId = $(this).attr('data-id');
                let actionUpdate = 'http://localhost:8080/Laravel/ismart.vn/admin/banner/update/'+ bannerId;
                $('#edit-banner').modal('show');
                $('#imgOut').attr('src', imgPath);
                if(statusItem == 'show'){
                    $('#update-status').prop("checked", true);
                }
                else{
                    $('#update-status').prop("checked", false);
                }
                $('#update-banner').attr('action', actionUpdate);
            });

            // Xóa banner
            let url;
            $(".delete").on('click', function (event) {
                event.preventDefault();
                url = $(this).attr('href');
                $("#delete-banner").modal('show');
            });
            $('#ok-delete').on('click', function () {
                $.ajax({
                    url: url,
                    beforeSend: function () {
                        $('#ok-delete').text('Đang xóa');
                    },
                    success: function (result) {
                        location.reload();
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
        });
    </script>
@endsection
