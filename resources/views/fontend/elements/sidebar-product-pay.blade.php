<div class="section" id="selling-wp">
    <div class="section-head">
        <p class="section-title">Sản phẩm bán chạy</p>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($productPay as $item)
                <li class="clearfix">
                    <a href="{{route('product.detail', ['category' => $item->category->slug, 'slug' => $item->slug, 'id' => $item->id])}}" title="" class="thumb fl-left">
                    <img src="{{url($item->avatar)}}" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="{{route('product.detail', ['category' => $item->category->slug, 'slug' => $item->slug, 'id' => $item->id])}}" title="" class="product-name">{{$item->name}}</a>
                        <div class="price">
                            @if ($item->discount)
                                <span class="new">{{number_format($item->discount, 0, ',', '.')}}đ</span>
                                <span class="old">{{number_format($item->price, 0, ',', '.')}}đ</span>
                            @else
                            <span class="new">{{number_format($item->price, 0, ',', '.')}}đ</span>
                            @endif
                        </div>
                        <a href="{{route('cart.buy_now', ['id' => $item->id])}}" title="" class="buy-now">Mua ngay</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

