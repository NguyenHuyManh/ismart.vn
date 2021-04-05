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
        <form class="login100-form validate-form" id="submit-login" action="{{ route('admin.check_login') }}" method="POST">
            @csrf
            <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                <span class="label-input100">Email</span>
                <input class="input100" type="text" id="email" name="email" value="{{old('email')}}">
                <span class="focus-input100"></span>               
                <div class="alert alert-danger error-email" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>             
            </div>
            <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                <span class="label-input100">Mật khẩu</span>
                <input class="input100" type="password" id="password" name="password">
                <span class="focus-input100"></span>
                <div class="alert alert-danger error-password" style="background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>               
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
            <div class="alert alert-dark error-account" style="margin-top: 10px; background: none; border: none; padding: 5px 0 0 0; font-size: 16px"></div>
        </form>
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
                        console.log(data);
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
                            window.location.href = "{{ url('admin/dashboard') }}";
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
