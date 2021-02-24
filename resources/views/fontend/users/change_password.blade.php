@extends('fontend.layout.account')

@section('title')
    <title>ISMART STORE - Điện thoại, Laptop, Phụ kiện</title>
@endsection

@section('content')
    <div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
        <div class="section" id="my-account-wp">
            <div class="section-head clearfix">
                <p class="my-account-section-title">Thay đổi mật khẩu</p>
                <p>Để bảo vệ tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.</p>
            </div>
            <div class="section-detail">
                <div class="my-account-profile">
                    @if(Auth::guard('customer')->check())
                        <form
                            action="{{ route('user.save_change_password', ['id' => $customer->id]) }}"
                            method="POST">
                            @csrf
                            <div class="account-fullname">
                                <label class="input-label">Mật khẩu mới:</label>
                                <input type="password" id="account-fullname" name="password"
                                       placeholder="Mật khẩu từ 6 đến 32 kí tự">
                            </div>
                            @error('password')
                            <div class="alert alert-danger"
                                 style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                            @enderror
                            <div class="account-email">
                                <label class="input-label">Xác nhận:</label>
                                <input type="password" id="account-email" name="password_confirm"
                                       placeholder="Nhập lại mật khẩu mói">
                            </div>
                            @error('password_confirm')
                            <div class="alert alert-danger"
                                 style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px">{{ $message }}</div>
                            @enderror
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

