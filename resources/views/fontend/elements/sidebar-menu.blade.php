<div class="section" id="category-product-wp">
    <div class="section-head">
        <p class="section-title">Danh mục sản phẩm</p>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            @foreach ($categorys as $category)
                <li>
                    @if ($category->categoryChildrent->count() > 0)
                        <a href="#" title="">{{$category->name}}</a>
                        <ul class="sub-menu">
                            @foreach ($category->categoryChildrent as $categoryChildrent)
                                @if($categoryChildrent->status == 1)
                                    <li>
                                        <a href="{{route('category.product', ['slug' => $categoryChildrent->slug, 'id' => $categoryChildrent->id])}}"
                                           title="">{{$categoryChildrent->name}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <a href="{{route('category.product', ['slug' => $category->slug, 'id' => $category->id])}}"
                           title="">{{$category->name}}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

@yield('sidebar-product-pay')

@yield('filter')

@include('fontend.elements.banner')
