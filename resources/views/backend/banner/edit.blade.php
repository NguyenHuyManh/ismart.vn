@extends('backend.home')

@section('title')
    <title>Cập nhật banner</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Cập nhật banner</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.banner.update', ['id' => $banner->id])}}" method="POST"
                      enctype="multipart/form-data" id="form-upload">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="slider" class="font-weight-bold">Ảnh banner *:</label>
                                <input class="form-control-file" type="file" name="image" id="imgInp">
                            </div>
                            <div class="form-group">
                                <img src="{{url($banner->image)}}" class="img-thumbnail" alt="" style="width: 200px"
                                     id="imgOut">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Trạng thái:</label>
                                <div class="form-check">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" value="1" {{ $banner->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Hiển thị</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection