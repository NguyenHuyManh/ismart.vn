<div id="foot-body">
    <div class="wp-inner clearfix">
        <div class="block" id="info-company">
            <h3 class="title">ISMART</h3>
            <p class="desc">{{ $setting->slogan }}</p>
            {{--            <div id="payment">--}}
            {{--                <div class="thumb">--}}
            {{--                    <img src="{{asset('fontend/public/images/img-foot.png')}}" alt="">--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
        <div class="block menu-ft" id="info-shop">
            <h3 class="title">Thông tin cửa hàng</h3>
            <ul class="list-item">
                <li>
                    <p>{{ $setting->address }}</p>
                </li>
                <li>
                    <p>{{ $setting->phone }}</p>
                </li>
                <li>
                    <p>{{ $setting->email }}</p>
                </li>
            </ul>
        </div>
        <div class="block menu-ft policy" id="info-shop">
            <h3 class="title">Chính sách mua hàng</h3>
            <ul class="list-item">
                @foreach($purchasePolicy as $item)
                    <li>
                        <a href="{{ route('purchase_policy.show', ['slug' => $item->slug, 'id' => $item->id]) }}"
                           title="">{{ $item->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="block" id="newfeed">
            <h3 class="title">Fan Page</h3>
            <div id="form-fan-page">
                {!! $setting->fanpage !!}
            </div>
        </div>
    </div>
</div>
<div id="foot-bot">
    <div class="wp-inner">
        <p id="copyright">{{ $setting->copyright }}</p>
    </div>
</div>
