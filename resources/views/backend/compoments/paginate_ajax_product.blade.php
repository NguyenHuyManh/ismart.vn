<table class="table table-hover table-checkall">
    <thead>
    <tr>
        <th scope="col">
            <input class="checkall" type="checkbox">
        </th>
        <th scope="col">Stt</th>
        <th scope="col">Ảnh</th>
        <th scope="col">Tên sản phẩm</th>
        <th scope="col">Giá</th>
        <th scope="col">Danh mục</th>
        <th scope="col">Ngày tạo</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Nổi bật</th>
        <th scope="col">Tác vụ</th>
    </tr>
    </thead>
    <tbody id="myTable">
    @if ($products->count() > 0)
        @php
            $stt = 1;
        @endphp
        @foreach ($products as $product)
            <tr class="">
                <td>
                    <input type="checkbox" name="product_id[]" value="{{$product->id}}" class="check-childrent">
                </td>
                <td>{{$stt++}}</td>
                <td><img src="{{url($product->avatar)}}" class="img-thumbnail" width="70px"></td>
                <td style="width: 200px">{{$product->name}}</td>
                @if ($product->discount)
                    <td>{{number_format($product->discount,0,',','.')}}₫</td>
                @else
                    <td>{{number_format($product->price,0,',','.')}}₫</td>
                @endif
                <td>{{$product->category->name}}</td>
                <td>
                    <span><i class="fas fa-user"></i> {{$product->user->name}}</span><br>
                    <span><i class="far fa-clock"></i> {{$product->created_at->format('H:i d-m-Y')}}</span>
                </td>
                <td>
                    @if ($product->status == 1)
                        <a href="{{ route('admin.product.update_status', ['id' => $product->id]) }}"
                           class="badge badge-success"
                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển
                            thị</a>
                    @else
                        <a href="{{ route('admin.product.update_status', ['id' => $product->id]) }}"
                           class="badge badge-danger"
                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>
                    @endif
                </td>
                <td>
                    @if ($product->highlight == 1)
                        <a href="{{ route('admin.product.update_highlight', ['id' => $product->id]) }}"
                           class="badge badge-success"
                           style="padding: 10px 10px; font-size: 13px;border-radius: 1.25rem !important">Nổi
                            bật</a>
                    @else
                        <a href="{{ route('admin.product.update_highlight', ['id' => $product->id]) }}"
                           class="badge badge-danger"
                           style="padding: 10px 13px; font-size: 13px;border-radius: 1.25rem !important">Không</a>
                    @endif

                </td>
                <td>
                    <a href="{{route('product.detail', ['category' => $product->category->slug, 'slug' => $product->slug, 'id' => $product->id])}}"
                       class="btn btn-primary btn-sm rounded-0 text-white" type="button"
                       data-toggle="tooltip" data-placement="top" title="Xem" target="_blank"><i
                            class="far fa-eye"></i></a>
                    @can('edit-product')
                        <a href="{{route('admin.product.edit',['id' => $product->id])}}"
                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                             class="fa fa-edit"></i></a>
                    @endcan
                    @can('delete-product')
                        <a href="{{route('admin.product.destroy', ['id' => $product->id])}}"
                        class="btn btn-danger btn-sm rounded-0 text-white delete"
                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                             class="fa fa-trash"></i></a>
                    @endcan
                </td>
            </tr>
        @endforeach
    @else
        <td colspan="10" style="text-align: center; color: red; font-weight: bold">Không có sản phẩm
            nào!
        </td>
    @endif
    </tbody>
</table>
{{$products->links()}}