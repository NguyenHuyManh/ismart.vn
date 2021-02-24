@extends('backend.home')

@section('title')
    <title>Giới thiệu</title>
@endsection

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Giới thiệu</h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.introduce.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" id="myTextarea" cols="30" rows="14">
                            @if ($introduce)
                                {{$introduce->content}}
                            @endif
                        </textarea>
                        @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @can('update-introduce')
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                    @endcan
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
