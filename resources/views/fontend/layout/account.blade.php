<!DOCTYPE html>
<html>
<head>
    @yield('title')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('admin//images/icons/hi.ico')}}"/>
    @include('fontend.elements.css')
    {{-- Thông tin tài khoản --}}
    <link rel="stylesheet" href="{{asset('fontend/public/account.css')}}">
    <link rel="stylesheet" href="{{asset('fontend/public/css/jquery.datetimepicker.min.css')}}">
</head>
<body>
<div id="site">
    <div id="container">
        <div id="header-wp">
            @include('fontend.elements.header')
        </div>
        <div id="main-content-wp" class="clearfix blog-page">
            <div class="wp-inner">
                @yield('content')
                <div class="sidebar fl-left">
                    @if(Auth::guard('customer')->check())
                        <div class="userpage-sidebar">
                            <div class="user-page-header">
                                <p>Tài khoản của</p>
                                <p class="user-name">{{ Auth::guard('customer')->user()->name }}</p>
                            </div>
                            <ul class="user-page-menu selectable">
                                <li>
                                    <a href="{{ route('user.acount_info', ['id' => Auth::guard('customer')->user()->id]) }}"><i class="fa fa-user" aria-hidden="true"></i>Thông tin tài khoản</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.purchase', ['id' => Auth::guard('customer')->user()->id]) }}"><i class="fa fa-list-alt" aria-hidden="true"></i>Đơn hàng đã mua</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.change_password', ['id' => Auth::guard('customer')->user()->id]) }}"><i class="fa fa-wrench" aria-hidden="true"></i>Thay đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div> 
                    @endif
                </div>
            </div>
        </div>
        <div id="footer-wp">
            @include('fontend.elements.footter')
        </div>
    </div>
</div>
<div id="btn-top"><img src="{{asset('fontend/public/images/icon-to-top.png')}}" alt=""/></div>
@include('fontend.elements.script')
<!-- Datime Picker -->
<script src="{{asset('fontend/public/js/jquery.datetimepicker.full.min.js')}}"></script>
<script>
    jQuery.datetimepicker.setLocale('vi');
    $("#datepicker").datetimepicker({
        datepicker:true,
        timepicker:false,
        format:'d-m-Y',
        //theme:'dark'
    });
</script>
@include('sweetalert::alert')
</body>
</html>
