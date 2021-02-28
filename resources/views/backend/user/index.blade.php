@extends('backend.home')

@section('title')
    <title>Danh sách thành viên</title>
@endsection

@section('content')
    <!-- Modal Edit -->
    <div id="edit-admin" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="content-edit">

            </div>
        </div>
    </div>
    <!-- End Modal Edit -->
    <!-- Modal Delete -->
    <div id="delete-admin" class="modal fade" role="dialog">
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
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="" class="form-control form-search" placeholder="Tìm kiếm" id="myInput">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="form-action form-inline add-category">
                    @can('add-admin')
                        <a href="{{route('admin.user.create')}}" class="btn btn-primary">Thêm mới <i
                                class="fas fa-plus"></i></a>
                    @endcan
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Active</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($admins as $admin)
                        <tr>
                            <th scope="row">{{ $stt++ }}</th>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @foreach($admin->roles as $roleItem)
                                    <span class="badge badge-pill badge-primary">{{ $roleItem->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($admin->active == 1)
                                    <span class="badge badge-success"
                                          style="padding: 10px 20px; font-size: 13px; border-radius: 1.25rem !important">Yes</span>
                                @else
                                    <span class="badge badge-danger"
                                          style="padding: 10px 20px; font-size: 13px;border-radius: 1.25rem !important">No</span>
                                @endif
                            </td>
                            <td>
                                @can('edit-admin')
                                    <a href="{{ route('admin.user.edit', ['id' => $admin->id]) }}"
                                       class="btn btn-success btn-sm rounded text-white edit-admin"
                                       data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-admin')
                                    <a href="{{ route('admin.user.destroy', ['id' => $admin->id]) }}"
                                       class="btn btn-danger btn-sm rounded text-white delete"
                                       data-toggle="tooltip" data-placement="top" title="Delete">
                                       <i class="fas fa-trash-alt"></i>
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
        // Update admin
        $(".edit-admin").on('click', function (event) {
            event.preventDefault();
            let url = $(this).attr('href');

            $.ajax({
                url: url,
                success: function (result) {
                    if (result) {
                        $("#edit-admin").modal('show');
                        $("#content-edit").html('').append(result.data);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        // Xóa admin
        let urlDelete;
        $(".delete").on('click', function (event) {
            event.preventDefault();
            urlDelete = $(this).attr('href');
            $("#delete-admin").modal('show');
        });
        $('#ok-delete').on('click', function () {
            $.ajax({
                url: urlDelete,
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
