<div id="head-top" class="clearfix">
    <div class="wp-inner">
        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
        <div id="main-menu-wp" class="fl-right">
            <ul id="main-menu" class="clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="{{route('intro.index')}}" title="">Giới thiệu</a>
                </li>
                <li>
                    <a href="{{route('post.index')}}" title="">Tin tức</a>
                </li>
                <li>
                    <a href="{{route('contact.index')}}" title="">Liên hệ</a>
                </li>
                @if(Auth::guard('customer')->check())
                    <li>
                        <div class="dropdown account-container">
                            <p class="dropdown-toggle user-name" data-toggle="dropdown">
                                Hi! {{ Auth::guard('customer')->user()->name }}
                                <span class="caret"></span>
                            </p>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('user.acount_info', ['id' => Auth::guard('customer')->user()->id]) }}">Tài
                                        khoản của tôi</a></li>
                                <li>
                                    <a href="{{ route('user.purchase', ['id' => Auth::guard('customer')->user()->id]) }}">Đơn
                                        mua</a></li>
                                <li><a href="{{ route('user.logout') }}">Đăng xuất</a></li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li>
                        <a href="{{ url('/login') }}" title="">Đăng nhập</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}" title="">Đăng kí</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div id="head-body" class="clearfix">
    <div class="wp-inner">
        <a href="{{url('/')}}" title="" id="logo" class="fl-left"><img
                src="{{url($setting->logo)}}"/></a>
        <div id="search-wp" class="fl-left">
            <form method="Get" action="{{ route('search.product') }}" class="form-search">
                <input type="text" name="search" id="s" placeholder="Nhập từ khóa" value="{{ Request::get('search') }}">
                <button type="submit" id="sm-s"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <div id="action-wp" class="fl-right">
            <div id="advisory-wp" class="fl-left">
                <span class="title">Tư vấn</span>
                <span class="phone">{{ $setting->phone }}</span>
            </div>
            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
            <a href="{{route('cart.index')}}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span id="num">2</span>
            </a>
            <div id="cart-wp" class="fl-right">
                <div id="btn-cart">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span id="num">
                        @if (Cart::count() > 0)
                            {{Cart::count()}}
                        @endif
                    </span>
                </div>
                <div id="dropdown">
                    @include('fontend.compoments.dropdown-cart')
                </div>
            </div>
        </div>
    </div>
</div>
