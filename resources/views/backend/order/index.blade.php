@extends('backend.home')

@section('title')
    <title>Đơn hàng</title>
@endsection

@section('content')
    <!-- Modal Delete -->
    <div id="delete-order" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-warning" style="padding: 10px">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center font-weight-bold">
                    <p style="margin: 5px">Bạn có chắc muốn xóa?</p>
                </div>
                <div class="modal-footer" style="padding: 10px">
                    <button type="submit" class="btn btn-primary" id="ok-delete">Xóa</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Delete -->
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="" class="form-control form-search" name="keyword" id="myInput"
                               placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic mb-3">
                    <a href="{{ route('admin.order.index') }}" class="text-primary">Tất cả<span class="text-muted">({{ $count_order[0]}})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'finish'])}}" class="text-primary">Đã giao<span
                            class="text-muted">({{ $count_order[1]}})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'processing'])}}" class="text-primary">Đang xử
                        lý<span class="text-muted">({{ $count_order[2]}})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'no-process'])}}" class="text-primary">Chưa xử
                        lý<span class="text-muted">({{ $count_order[3]}})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancel'])}}" class="text-primary">Đơn hàng hủy<span
                            class="text-muted">({{ $count_order[4]}})</span></a>
                </div>
                <table class="table table-hover table-checkall text-center">
                    <thead>
                    <tr>
                        <th scope="col">Stt</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Chi tiết</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @if ($orders->count() > 0)
                        @php
                            $stt = 1;
                        @endphp
                        @foreach( $orders as $item)
                            <tr>
                                <td>{{ $stt++ }}</td>
                                <td>{{ $item->code }}</td>
                                <td>
                                    <span>{{ $item->customer->name }}</span><br>
                                    <span>{{ $item->phone }}</span>
                                </td>
                                <td>{{ $item->note }}</td>
                                <td>{{ number_format($item->total_money, '0', ',', '.') }}₫</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-secondary">Chưa xử lý</span>
                                    @elseif ($item->status == 2)
                                        <span class="badge badge-warning">Đang xử lý</span>
                                    @elseif ($item->status == 3)
                                        <span class="badge badge-success">Đã giao</span>
                                    @else
                                        <span class="badge badge-dark">Hủy</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('H:i d-m-Y') }}</td>
                                <td>
                                    @can('detail-order')
                                        <a href="{{route('admin.order.show', ['id' => $item->id])}}"
                                           class="btn btn-primary btn-sm rounded-0 text-white" type="button"
                                           data-toggle="tooltip" data-placement="top" title="Xem"><i
                                                class="far fa-eye"></i></a>
                                    @endcan
                                </td>
                                <td>
                                    @can('delete-order')
                                        <a href="{{ route('admin.order.destroy', ['id' => $item->id]) }}"
                                           class="btn btn-danger btn-sm rounded-0 text-white delete"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="10" style="text-align: center; color: red; font-weight: bold">Không có đơn hàng
                            nào!
                        </td>
                    @endif
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Xóa danh mục sản phẩm
        let url;
        $(".delete").on('click', function (event) {
            event.preventDefault();
            url = $(this).attr('href');
            $("#delete-order").modal('show');
        });
        $('#ok-delete').on('click', function () {
            $.ajax({
                url: url,
                beforeSend: function () {
                    $('#ok-delete').text('Đang xóa');
                },
                success: function (result) {
                    if (result.message == 'ok') {
                        location.reload();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
