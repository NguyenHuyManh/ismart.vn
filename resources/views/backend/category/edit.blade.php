@extends('backend.home')

@section('title')
    <title>Sửa danh mục</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Cập nhật danh mục</h5>
            </div>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{route('admin.category.update', ['id' => $category->id])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Tên danh mục *:</label>
                                <input class="form-control" type="text" name="name" id="name"
                                       value="{{$category->name}}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug" class="font-weight-bold">Slug:</label>
                                <input class="form-control" type="text" name="slug" id="slug" placeholder="dien-thoai"
                                       value="{{$category->slug}}">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Danh mục cha:</label>
                                <select class="form-control" id="" name="parent_id">
                                    <option value='0'>Chọn danh mục</option>
                                    {!! $htmlSelect !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="meta_title" class="font-weight-bold">Meta title:</label>
                                <input class="form-control" type="text" name="meta_title" id="meta_title"
                                       value="{{$category->meta_title}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_desc" class="font-weight-bold">Meta description:</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_desc"
                                       value="{{$category->meta_desc}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword" class="font-weight-bold">Meta keyword:</label>
                                <input class="form-control" type="text" id="meta_keyword" name="meta_keyword"
                                       value="{{$category->meta_keyword}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Trạng thái:</label>
                        <div class="form-check">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Hiển thị</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_cat">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection


