@if ($itemAdmin)
    <form action="{{ route('admin.user.update', ['id' => $itemAdmin->id]) }}" method="POST" id="admin-validate">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Cập nhật</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="name" class="font-weight-bold">Họ và tên:</label>
                <input class="form-control" disabled type="text" name="name" id="name" value="{{ $itemAdmin->name }}">
            </div>
            <div class="form-group">
                <label for="email" class="font-weight-bold">Email:</label>
                <input class="form-control" disabled type="text" name="email" id="email"
                       value="{{ $itemAdmin->email }}">
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Chọn vai trò:</label><br>
                <select class="form-control select2" name="role_id[]" multiple>
                    <option value=""></option>
                    @foreach($roleAll as $role)
                        <option
                            {{ $roleOfAdmin->contains('id', $role->id) ? 'selected' : '' }}
                            value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="" class="font-weight-bold">Active:</label>
                <div class="form-check">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="active" value="1" {{ $itemAdmin->active == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleCheck1">Có</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </form>
    <script>
        $('.select2').select2({
            placeholder: 'Chọn vai trò'
        });
    </script>
@endif


