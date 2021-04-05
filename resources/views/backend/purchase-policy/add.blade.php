@extends('backend.home')

@section('title')
    <title>Thêm chính sách</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0">Thêm chính sách</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.purchase_policy.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Tiêu đề *:</label>
                                <input class="form-control" type="text" name="title" value="{{old('title')}}">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug" class="font-weight-bold">Slug:</label>
                                <input class="form-control" type="text" name="slug" placeholder="Vd: abc-xyz"
                                       value="{{old('slug')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="font-weight-bold">Nội dung *:</label>
                        <textarea name="content" class="form-control" id="myTextarea" cols="30"
                                  rows="8">{{old('content')}}</textarea>
                        @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Trạng thái:</label>
                        <div class="form-check">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="status" value="1">
                            <label class="form-check-label" for="exampleCheck1">Hiển thị</label>
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
