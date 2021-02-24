@extends('backend.home')

@section('title')
    <title>Cập nhật nhóm quyền</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Cập nhật nhóm quyền</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role.update', ['id' => $role->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Tên nhóm quyền:</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{ $role->name }}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="display_name" class="font-weight-bold">Mô tả nhóm quyền:</label>
                                <textarea class="form-control" name="display_name" id="display_name"
                                          rows="3">{{ $role->display_name }}</textarea>
                                @error('display_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            @foreach($permissions as $permission)
                                <div class="card card-wrapper mb-3">
                                    <div class="card-header bg-info">
                                        <div class="form-check">
                                            <label class="form-check-label text-capitalize">
                                                <input type="checkbox"
                                                       class="form-check-input checkbox-parent">{{ $permission->name }}
                                                ({{ $permission->display_name }})
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        @foreach($permission->permissionChildrent as $item)
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="permission_id[]"
                                                               {{ $permissionChecked->contains('id', $item->id) ? 'checked' : '' }}
                                                               value="{{ $item->id }}"
                                                               class="form-check-input checkbox-childrent">{{ $item->name }}
                                                        ({{ $item->display_name }})
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @error('permission_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection


