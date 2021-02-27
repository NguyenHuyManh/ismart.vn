<div class="navbar-brand"><a href="{{url('admin/dashboard')}}">ISMART ADMIN</a></div>
<div class="nav-right float-right">
    {{-- <div class="btn-group mr-auto">
        <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="plus-icon fas fa-plus-circle"></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('admin.post.create')}}">Thêm bài viết</a>
            <a class="dropdown-item" href="{{route('admin.product.create')}}">Thêm sản phẩm</a>
        </div>
    </div> --}}
    <div class="btn-group">
        <button type="button" class="btn dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            {{-- Hello! {{get_data_user('admins','name')}} --}}
            Hello! {{ Auth::user()->name }}
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('admin.user.info_account', ['id' => Auth::user()->id]) }}">Tài
                khoản</a>
            <a class="dropdown-item" href="{{route('admin.logout')}}">Đăng xuất</a>
        </div>
    </div>
</div>

