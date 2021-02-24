@extends('backend.home')

@section('title')
    <title>Thông tin tài khoản</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-body" style="background: #f7f7f7;">
                <h5 class="title m-0 font-weight-bold text-center">Thông tin tài khoản</h5>
                <div class="info-content">
                    <form action="{{ route('admin.user.update_account', ['id' => $infoAccount->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Họ và tên *:</label>
                            <input class="form-control" type="text" name="name" id="name"
                                   value="{{ $infoAccount->name }}">
                            @error('name')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email *:</label>
                            <input class="form-control" type="text" name="email" id="email"
                                   value="{{ $infoAccount->email }}" disabled>
                            @error('email')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Số điện thoại:</label>
                            <input class="form-control" type="text" name="phone" id="phone"
                                   value="{{ $infoAccount->phone }}">
                            @error('phone')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address" class="font-weight-bold">Địa chỉ:</label>
                            <input class="form-control" type="text" name="address" id="address"
                                   value="{{ $infoAccount->address }}">
                            @error('address')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <h6 class="font-weight-bold text-center">Thay đổi mật khẩu:</h6>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Mật khẩu mới:</label>
                            <input class="form-control" type="password" name="password" id="password"
                                   placeholder="******">
                            @error('password')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirm" class="font-weight-bold">Nhập lại mật khẩu:</label>
                            <input class="form-control" type="password" name="password_confirm" id="password_confirm"
                                   placeholder="******">
                            @error('password_confirm')
                            <div class="alert alert-danger"
                                 style="background-color: unset; padding: 5px 0 0 0;color: red;border: none">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
