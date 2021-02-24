@extends('backend.home')

@section('title')
    <title>Thêm sản phẩm</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Thêm sản phẩm</h5>
            </div>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ route('admin.product.store')}}" method="POST" enctype="multipart/form-data"
                      id="form-upload">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Tên sản phẩm *:</label>
                                <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price" class="font-weight-bold">Giá *:</label>
                                <input class="form-control  format-money" type="text" name="price" id="price"
                                       value="{{old('price')}}">
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">Số lượng *:</label>
                                <input class="form-control" type="number" name="amount" id="amount"
                                       value="{{old('amount')}}">
                                @error('amount')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Danh mục *:</label>
                                <select class="form-control" id="" name="category_id">
                                    <option value="">Chọn danh mục</option>
                                    {!! $htmlSelect !!}
                                </select>
                                @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="discount" class="font-weight-bold">Giá khuyễn mại:</label>
                                <input class="form-control format-money" type="text" name="discount" id="discount"
                                       value="{{old('discount')}}">
                            </div>
                            <div class="form-group">
                                <label for="slug" class="font-weight-bold">Slug:</label>
                                <input class="form-control" type="text" name="slug" id="slug" value="{{old('slug')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="intro" class="font-weight-bold">Chi tiết sản phẩm *:</label>
                                <textarea name="content" class="form-control" id="myTextarea1" cols="30"
                                          rows="4">{{old('content')}}</textarea>
                                @error('content')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="meta_title" class="font-weight-bold">Meta title:</label>
                                <input class="form-control" type="text" name="meta_title" id=""
                                       value="{{old('meta_title')}}">
                                @error('meta_title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="meta_desc" class="font-weight-bold">Meta description:</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_desc"
                                       value="{{old('meta_desc')}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword" class="font-weight-bold">Meta keyword:</label>
                                <input class="form-control" type="text" id="meta_keyword" name="meta_keyword"
                                       value="{{old('meta_keyword')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="intro" class="font-weight-bold">Mô tả sản phẩm:</label>
                        <textarea name="desc" class="form-control" id="myTextarea" cols="30"
                                  rows="10">{{old('desc')}}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Ảnh đại diện *:</label>
                                <input class="form-control-file" type="file" name="avatar" id="imgInp">
                                @error('avatar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <img src="{{asset('admin/images/images.png')}}" alt="" id="imgOut" class="img-thumbnail"
                                     style="width: 150px">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Ảnh chi tiết:</label>
                                <input class="form-control-file" multiple type="file" name="image_detail[]"
                                       id="imgInp1">
                                @error('image_detail')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Trạng thái:</label>
                                <div class="form-check">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" value="1">
                                    <label class="form-check-label" for="exampleCheck1">Hiển thị</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Nổi bật:</label>
                                <div class="form-check">
                                    <input type="hidden" name="highlight" value="0">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck2" name="highlight" value="1">
                                    <label class="form-check-label" for="exampleCheck2">Có</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var editor_config = {
            path_absolute: "http://localhost:8080/Laravel/ismart.vn/",
            selector: "#myTextarea1",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <script>
        var editor_config = {
            path_absolute: "http://localhost:8080/Laravel/ismart.vn/",
            selector: "#myTextarea",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection
