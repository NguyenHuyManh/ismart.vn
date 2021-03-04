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
            <form action="{{ route('user.login') }}" method="Post" id="submit-login">
                @csrf
                <div class="info-email">
                    <label for="email">Email:</label><br>
                    <input type="text" id="email" name="email" placeholder="Nhập email...">
                    <div class="alert alert-danger error-email" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                </div>
                <div class="info-password">
                    <label for="password">Mật khẩu:</label><br>
                    <input type="password" id="password" name="password" placeholder="Mật khẩu từ 6 đến 32 kí tự">
                    {{--<i class="fa fa-eye" aria-hidden="true"></i>--}}
                    <div class="alert alert-danger error-password" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                </div>
                <div class="submit-login">
                    <button type="submit" class="btn-login">Đăng nhập</button>
                </div>
                    <div class="alert alert-danger error-account" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
                <div class="forgot-password">
                    <a href="{{ route('get.form.reset_password') }}">Quên mật khẩu?</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.error-email').hide();
            $('.error-password').hide();
            $('.error-account').hide();
            $(document).on('submit', '#submit-login', function(e){
                e.preventDefault();
                let _token = $("input[name=_token]").val();
                let url = $('#submit-login').attr('action');
                let email = $('#email').val();
                let password = $('#password').val();
                $.ajax({
                    url : url,
                    type: 'POST',
                    data: {_token: _token, email: email, password: password},
                    dataType: 'json',
                    success: function(data){
                        $('.error-email').hide();
                        $('.error-password').hide();
                        $('.error-account').hide();
                        if(data.error == true) {
                            if(data.message.email){
                                $('.error-email').show();
                                $('.error-email').text(data.message.email[0]);
                            }
                            if(data.message.password) {
                                $('.error-password').show();
                                $('.error-password').text(data.message.password[0]);
                            }
                        }
                        if(data.login == 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                        if(data.login == 'error') {
                            $('.error-account').show();
                            $('.error-account').text(data.message);
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
