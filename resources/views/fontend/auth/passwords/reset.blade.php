@extends('fontend.layout.login-register')

@section('title')
    <title>Quên mật khẩu</title>
@endsection

@section('content')
    <div class="form-login">
        <div class="header">
            <h3 class="title">Lấy lại mật khẩu</h3>
        </div>
        <div class="content">
            <form action="" method="POST">
                @csrf
                <div class="info-password">
                    <label for="password">Mật khẩu:</label><br>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    @error('password')
                        <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="password_confirmation">
                    <label for="password_confirmation">Xác thực:</label><br>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Nhập lại mật khẩu">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    @error('password_confirmation')
                        <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="submit-login">
                    <button type="submit" class="btn-login">Đặt lại mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
