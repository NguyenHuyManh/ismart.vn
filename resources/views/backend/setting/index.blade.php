@extends('backend.home')

@section('title')
    <title>Quản lý Setting</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Cài đặt chung</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.setting.update')}}" method="POST" enctype="multipart/form-data"
                      id="form-upload">
                    @csrf
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <div class="form-group row">
                                <label for="logo" class="font-weight-bold col-sm-2 col-form-label">Logo:</label>
                                <div class="col-sm-10">
                                    <input type="file" name="logo" class="form-control-file" id="imgInp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="font-weight-bold col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="{{url($item->logo)}}" id="imgOut" class="img-thumbnail" alt=""
                                         style="width: 150px; background: gainsboro;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="slogan" class="font-weight-bold col-sm-2 col-form-label">Slogan:</label>
                                <div class="col-sm-10">
                                    <textarea name="slogan" id="slogan" cols="30" rows="4" class="form-control">{{ $item->slogan }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="copyright" class="font-weight-bold col-sm-2 col-form-label">Copy
                                    right:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="copyright" id="copyright" value="{{ $item->copyright }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fanpage" class="font-weight-bold col-sm-2 col-form-label">Fan Page:</label>
                                <div class="col-sm-10">
                                    <textarea name="fanpage" id="fanpage" cols="30" rows="4" class="form-control">{{ $item->fanpage }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <h6 class="font-weight-bold text-center">Thông tin cửa hàng:</h6>
                            </div>
                            <div class="input-group flex-nowrap mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="address" value="{{ $item->address }}" class="form-control" placeholder="Nhập địa chỉ">
                            </div>
                            <div class="input-group flex-nowrap mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="text" name="phone" value="{{ $item->phone }}" class="form-control" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="input-group flex-nowrap mb-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-wrapping"><i
                                            class="fas fa-envelope"></i></span>
                                </div>
                                <input type="text" name="email" value="{{ $item->email }}" class="form-control" placeholder="Nhập email">
                            </div>
                            @can('update-setting')
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
