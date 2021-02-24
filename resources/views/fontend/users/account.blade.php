@extends('fontend.layout.account')

@section('title')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
@endsection

@section('content')
    <div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
        <div class="section" id="my-account-wp">
            <div class="section-head clearfix">
                <p class="my-account-section-title">Hồ sơ của tôi</p>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            </div>
            <div class="section-detail">
                <div class="my-account-profile">
                    @if(Auth::guard('customer')->check())
                        <form
                            action="{{ route('user.update_account_info', ['id' => Auth::guard('customer')->user()->id]) }}"
                            method="POST">
                            @csrf
                            <div class="account-fullname">
                                <label class="input-label">Họ tên:</label>
                                <input type="text" id="account-fullname" name="name"
                                       value="{{ Auth::guard('customer')->user()->name }}">
                            </div>
                            @error('name')
                            <div class="alert alert-danger"
                                 style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                            @enderror
                            <div class="account-email">
                                <label class="input-label">Email đăng nhập:</label>
                                <input type="text" id="account-email" name="email"
                                       value="{{ Auth::guard('customer')->user()->email }}">
                            </div>
                            @error('email')
                            <div class="alert alert-danger"
                                 style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                            @enderror
                            <div class="account-phone">
                                <label class="input-label">Số điện thoại:</label>
                                <input type="text" id="account-phone" name="phone"
                                       value="{{ Auth::guard('customer')->user()->phone }}">
                            </div>
                            @error('phone')
                            <div class="alert alert-danger"
                                 style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                            @enderror
                            <div class="account-address">
                                <label class="input-label">Địa chỉ:</label>
                                <input type="text" id="account-address" name="address"
                                       value="{{ Auth::guard('customer')->user()->address }}">
                            </div>
                            <div class="account-birthday">
                                <label class="input-label">Ngày sinh:</label>
                                <input type="text" id="datepicker" name="birth_day"
                                       value="{{ Auth::guard('customer')->user()->birth_day }}">
                            </div>
                            <div class="submit-save">
                                <label class="input-label"></label>
                                <button type="submit" class="btn-save">Lưu</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

