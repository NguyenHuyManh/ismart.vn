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
            <form action="{{ route('user.register') }}" method="Post" id="submit-register">
                @csrf
                <div class="info-fullname">
                    <label for="name">Họ tên:</label><br>
                    <input type="text" id="name" name="name" placeholder="Nhập họ tên" value="{{ old('name') }}">
                   
                    <div class="alert alert-danger error-fullname"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                    
                </div>
                <div class="info-email">
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" placeholder="Nhập email..." value="{{ old('email') }}">
                    
                    <div class="alert alert-danger error-email"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                   
                </div>
                <div class="info-phone">
                    <label for="phone">Số điện thoại:</label><br>
                    <input type="text" id="phone" name="phone" placeholder="Nhập phone..." value="{{ old('phone') }}">
                   
                    <div class="alert alert-danger error-phone"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                    
                </div>
                <div class="info-password">
                    <label for="password">Mật khẩu:</label><br>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                    {{--<i class="fa fa-eye" aria-hidden="true"></i>--}}
                    
                    <div class="alert alert-danger error-password"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                    
                </div>
                <div class="password_confirmation">
                    <label for="password_confirmation">Xác thực:</label><br>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Nhập lại mật khẩu">
                    {{--<i class="fa fa-eye-slash" aria-hidden="true"></i>--}}
                    
                    <div class="alert alert-danger error-password-confirmation"
                         style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                   
                </div>
                <div class="submit-register">
                    <button type="submit" class="btn-register">Đăng kí</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.error-fullname').hide();
            $('.error-email').hide();
            $('.error-password').hide();
            $('.error-phone').hide();
            $('.error-password-confirmation').hide();
            $(document).on('submit', '#submit-register', function(e){
                e.preventDefault();
                let _token = $("input[name=_token]").val();
                let url = $('#submit-register').attr('action');
                let email = $('#email').val();
                let password = $('#password').val();
                let name = $('#name').val();
                let phone = $('#phone').val();
                let password_confirmation = $('#password_confirmation').val();
                $.ajax({
                    url : url,
                    type: 'POST',
                    data: {_token: _token, email: email, password: password, name: name, phone: phone, password_confirmation: password_confirmation},
                    dataType: 'json',
                    success: function(data){
                        $('.error-fullname').hide();
                        $('.error-email').hide();
                        $('.error-password').hide();
                        $('.error-phone').hide();
                        $('.error-password-confirmation').hide();
                        if(data.error == true) {
                            if(data.message.email){
                                $('.error-email').show();
                                $('.error-email').text(data.message.email[0]);
                            }
                            if(data.message.password) {
                                $('.error-password').show();
                                $('.error-password').text(data.message.password[0]);
                            }
                            if(data.message.name){
                                $('.error-fullname').show();
                                $('.error-fullname').text(data.message.name[0]);
                            }
                            if(data.message.phone) {
                                $('.error-phone').show();
                                $('.error-phone').text(data.message.phone[0]);
                            }
                            if(data.message.password_confirmation) {
                                $('.error-password-confirmation').show();
                                $('.error-password-confirmation').text(data.message.password_confirmation[0]);
                            }
                        }
                        if(data.register == 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        })
    </script>
@endsection
