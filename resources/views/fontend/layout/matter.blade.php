<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <link rel="icon" type="image/png" href="{{asset('admin//images/icons/hi.ico')}}"/>
    @include('fontend.elements.css')
</head>
<body>
<div id="site">
    <div id="container">
        <div id="header-wp">
            @include('fontend.elements.header')
        </div>
        <div id="main-content-wp" class="home-page clearfix">
            <div class="wp-inner">
                @yield('breadcrumb')
                <div class="main-content fl-right">
                    @yield('content')
                </div>
                <div class="sidebar fl-left">
                    @include('fontend.elements.sidebar-menu')
                </div>
            </div>
        </div>
        <div id="footer-wp">
            @include('fontend.elements.footter')
        </div>
    </div>

    <div id="btn-top"><img src="{{asset('fontend/public/images/icon-to-top.png')}}" alt=""/></div>

</div>
@include('fontend.elements.script')
@include('sweetalert::alert')
</body>
</html>
