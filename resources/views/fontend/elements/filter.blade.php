<div class="section" id="filter-product-wp">
    <div class="section-head">
        <p class="section-title">Bộ lọc sản phẩm</p>
    </div>
    <div class="section-detail">
        <ul class="fillter-product">
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 1]) }}"
                   class="{{ Request::get('price') == 1 ? 'active' : '' }}">Dưới
                    500.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 2]) }}"
                   class="{{ Request::get('price') == 2 ? 'active' : '' }}">500.000 - 1.000.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 3]) }}"
                   class="{{ Request::get('price') == 3 ? 'active' : '' }}">1.000.000 - 3.000.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 4]) }}"
                   class="{{ Request::get('price') == 4 ? 'active' : '' }}">3.000.000 - 5.000.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 5]) }}"
                   class="{{ Request::get('price') == 5 ? 'active' : '' }}">5.000.000 - 7.000.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 6]) }}"
                   class="{{ Request::get('price') == 6 ? 'active' : '' }}">7.000.000 - 10.000.000đ</a></li>
            <li><a href="{{ request()->fullUrlWithQuery(['price' => 7]) }}"
                   class="{{ Request::get('price') == 7 ? 'active' : '' }}">Trên 10.000.000đ</a></li>
        </ul>
    </div>
</div>
