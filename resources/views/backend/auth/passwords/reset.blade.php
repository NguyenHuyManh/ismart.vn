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
        <form class="login100-form validate-form" action="" method="POST">
            @csrf
            <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                <span class="label-input100">Mật khẩu</span>
                <input class="input100" type="password" name="password">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span class="focus-input100"></span>
            </div>
            <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                <span class="label-input100">Xác nhận mật khẩu</span>
                <input class="input100" type="password" name="password_comfirm">
                @error('password_comfirm')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <span class="focus-input100"></span>
            </div>
            <div class="container-login100-form-btn">
                <button type="submit" class="login100-form-btn">
                    Khôi phục mật khẩu
                </button>
            </div>
            @if (session('error'))
                <div class="alert alert-dark" style="margin-top: 10px">{{ session('error') }}</div>
            @endif
        </form>
    </div>
@endsection
