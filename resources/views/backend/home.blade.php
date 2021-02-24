<!DOCTYPE html>
<html lang="en">

<head>
    @yield('title')
    @include('backend.elements.head')
    @yield('css')
</head>

<body>
<div id="warpper" class="nav-fixed">
    <nav class="topnav shadow navbar-light bg-white d-flex">
        @include('backend.elements.menu-top')
    </nav>

    <div id="page-body" class="d-flex">
        <div id="sidebar" class="bg-white">
            @include('backend.elements.sidebar')
        </div>

        <div id="wp-content">
            @yield('content')
        </div>
    </div>
</div>

@include('backend.elements.script')
@yield('script')
@include('sweetalert::alert')
</body>

</html>


