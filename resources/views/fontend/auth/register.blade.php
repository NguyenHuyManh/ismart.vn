@extends('fontend.layout.login-register')

@section('title')
    <title>Đăng kí</title>
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
                        Đăng kí
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="form-register">
        <div class="header">
            <h3 class="title">Đăng kí</h3>
        </div>
        <div class="content">
            <form action="{{ route('user.register') }}" method="Post">
                @csrf
                <div class="info-fullname">
                    <label for="name">Họ tên:</label><br>
                    <input type="text" id="name" name="name" placeholder="Nhập họ tên" value="{{ old('name') }}">
                    @error('name')
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="info-email">
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" placeholder="Nhập email..." value="{{ old('email') }}">
                    @error('email')
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="info-phone">
                    <label for="phone">Số điện thoại:</label><br>
                    <input type="text" id="phone" name="phone" placeholder="Nhập phone..." value="{{ old('phone') }}">
                    @error('phone')
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
                <div class="password_confirmation">
                    <label for="password_confirmation">Xác thực:</label><br>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Nhập lại mật khẩu">
                    {{--<i class="fa fa-eye-slash" aria-hidden="true"></i>--}}
                    @error('password_confirmation')
                    <div class="alert alert-danger"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                    @enderror
                </div>
                <div class="submit-register">
                    <button type="submit" class="btn-register">Đăng kí</button>
                </div>
            </form>
        </div>
    </div>
@endsection
