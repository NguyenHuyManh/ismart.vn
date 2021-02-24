@extends('backend.home')

@section('title')
    <title>Thêm thành viên</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Thêm thành viên</h5>
            </div>
            <div class="card-body" style="width: 500px">
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Họ và tên:</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nhập họ tên...">
                        @error('name')
                        <div class="alert alert-danger"
                             style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email:</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Nhập email...">
                        @error('email')
                        <div class="alert alert-danger"
                             style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-bold">Mật khẩu:</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                        @error('password')
                        <div class="alert alert-danger"
                             style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="font-weight-bold">Nhập lại mật khẩu:</label>
                        <input class="form-control" type="password" name="password_confirm" id="password_confirm" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                        @error('password_confirm')
                        <div class="alert alert-danger"
                             style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Chọn vai trò:</label>
                        <select class="form-control select2" name="role_id[]" multiple>
                            <option value=""></option>
                            @foreach($roleAll as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="alert alert-danger"
                             style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Active:</label>
                        <div class="form-check">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="active" value="1">
                            <label class="form-check-label" for="exampleCheck1">Yes</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2({
            placeholder: 'Chọn vai trò'
        });
    </script>
@endsection
