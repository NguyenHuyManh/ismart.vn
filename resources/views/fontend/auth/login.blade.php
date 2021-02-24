@extends('fontend.layout.login-register')

@section('title')
    <title>Đăng nhập</title>
@endsection

@section('breadcrumb')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('/')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        Đăng nhập
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="form-login">
        <div class="header">
            <h3 class="title">Đăng Nhập</h3>
        </div>
        <div class="content">
            @if (session('status'))
                <div class="alert alert-succses"
                     style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ session('status') }}</div>
            @endif
            <form action="{{ route('user.login') }}" method="Post">
                @csrf
                <div class="info-email">
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" placeholder="Nhập email...">
                    @error('email')
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="info-password">
                    <label for="password">Mật khẩu:</label><br>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                    {{--<i class="fa fa-eye" aria-hidden="true"></i>--}}
                    @error('password')
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="submit-login">
                    <button type="submit" class="btn-login">Đăng nhập</button>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ session('error') }}</div>
                @endif
                <div class="forgot-password">
                    <a href="{{ route('get.form.reset_password') }}">Quên mật khẩu?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
