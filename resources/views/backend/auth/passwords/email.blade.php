@extends('backend.auth.app')

@section('title')
    <title>Lấy lại mật khẩu</title>
@endsection

@section('content')
    <div class="wrap-login100">
        <div class="login100-form-title" style="">
            <img src="{{asset('admin/login/images/bg-01.jpg')}}" alt="">
            <span class="login100-form-title-1">
			Reset Password
		</span>
        </div>
        @if (session('status'))
            <div class="alert alert-success" style="text-align: center">
                {{ session('status')}}
            </div>
        @endif
        <form class="login100-form validate-form" action="{{route('admin.send.reset.password')}}" method="POST">
            @csrf
            <p style="margin-bottom: 10px; font-size: 18px; font-weight: 500">Hệ thống sẽ gửi đường dẫn thiết lập lại
                mật khẩu vào email của bạn!</p>
            <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                <span class="label-input100">Email</span>
                <input class="input100" type="text" name="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span class="focus-input100"></span>
            </div>
            <div class="container-login100-form-btn">
                <button type="submit" class="login100-form-btn">
                    Gửi xác nhận
                </button>
            </div>
            @if (session('error'))
                <div class="alert alert-dark" style="margin-top: 10px">{{ session('error') }}</div>
            @endif
        </form>
    </div>
@endsection
