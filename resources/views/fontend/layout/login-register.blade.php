<!DOCTYPE html>
<html>
<head>
    @yield('title')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('admin//images/icons/hi.ico')}}"/>
    @include('fontend.elements.css')
</head>
<body>
<div id="site">
    <div id="container">
        <div id="header-wp">
            @include('fontend.elements.header')
        </div>
        <div id="main-content-wp" class="checkout-page">
            @yield('breadcrumb')
            <div id="wrapper" class="wp-inner clearfix">
                @yield('content')
            </div>
        </div>
        <div id="footer-wp">
            @include('fontend.elements.footter')
        </div>
    </div>

    <div id="btn-top"><img src="{{asset('fontend/public/images/icon-to-top.png')}}" alt=""/></div>
   
</div>
    @include('fontend.elements.script')
</body>
</html>
