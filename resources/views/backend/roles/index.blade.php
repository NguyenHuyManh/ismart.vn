@extends('backend.home')

@section('title')
    <title>Danh sách nhóm quyền</title>
@endsection

@section('content')
    <!-- Modal Delete -->
    <div id="delete-role" class="modal fade" role="dialog">
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
                <h5 class="m-0 ">Danh sách nhóm quyền</h5>

            </div>
            <div class="card-body">
                <div class="form-action form-inline add-category">
                @can('add-role')
                    <a href="{{ route('admin.role.create') }}" class="btn btn-primary">Thêm mới <i
                            class="fas fa-plus"></i></a>
                @endcan
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Stt</th>
                        <th scope="col">Tên nhóm quyền</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($roles as $role)
                        <tr>
                            <th scope="row">{{ $stt++ }}</th>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                            @can('edit-role')
                                <a href="{{ route('admin.role.edit', ['id' => $role->id]) }}"
                                   class="btn btn-success btn-sm rounded text-white edit-admin"
                                   data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            @endcan
                            @can('delete-role')
                                <a href="{{ route('admin.role.destroy', ['id' => $role->id]) }}"
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
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let urlDelete
        $('.delete').on('click', function (event) {
            event.preventDefault();
            urlDelete = $(this).attr('href');
            $('#delete-role').modal('show');
        })
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
                }
            })
        })
    </script>
@endsection
