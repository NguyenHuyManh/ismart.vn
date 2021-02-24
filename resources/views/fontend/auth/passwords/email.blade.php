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
            @if (session('status'))
                <div class="alert alert-succses" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px; font-style: italic">{{ session('status') }}</div>
            @endif
            <form action="{{ route('send.email.reset_password') }}" method="Post">
                @csrf
                <p class="reset-password">Hệ thống sẽ gửi đường dẫn thiết lập lại mật khẩu vào email của bạn!</p>
                <div class="info-email">
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" placeholder="Nhập email...">
                    @error('email')
                        <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="submit-login">
                    <button type="submit" class="btn-login">Gửi xác nhận</button>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ session('error') }}</div>
                @endif
            </form>
        </div>
    </div>
@endsection