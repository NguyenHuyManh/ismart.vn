@extends('backend.auth.app')

@section('title')
    <title>Đăng nhập hệ thống</title>
@endsection

@section('content')
    <div class="wrap-login100">
        <div class="login100-form-title" style="">
            <img src="{{asset('admin/login/images/bg-01.jpg')}}" alt="">
            <span class="login100-form-title-1">
			Sign In
		</span>
        </div>
        @if (session('status'))
            <div class="alert alert-success" style="text-align: center">
                {{ session('status')}}
            </div>
        @endif
        <form class="login100-form validate-form" action="{{ route('admin.check_login') }}" method="POST">
            @csrf
            <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                <span class="label-input100">Email</span>
                <input class="input100" type="text" name="email" value="{{old('email')}}">
                <span class="focus-input100"></span>
                @error('email')
                    <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                @enderror
            </div>
            <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                <span class="label-input100">Mật khẩu</span>
                <input class="input100" type="password" name="password">
                <span class="focus-input100"></span>
                @error('password')
                    <div class="alert alert-danger" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex-sb-m w-full p-b-30">
<!--                 <div class="contact100-form-checkbox">
                    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                    <label class="label-checkbox100" for="ckb1">
                        Remember me
                    </label>
                </div> -->
                <div>
                    <a href="{{route('admin.get.reset.password')}}" class="txt1">
                        Quên mật khẩu?
                    </a>
                </div>
            </div>

            <div class="container-login100-form-btn">
                <button type="submit" class="login100-form-btn">
                    Login
                </button>
            </div>
            @if (session('error'))
                <div class="alert alert-dark" style="margin-top: 10px; background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ session('error') }}</div>
            @endif
        </form>
    </div>
@endsection
