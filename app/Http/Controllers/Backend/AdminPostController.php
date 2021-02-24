<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\UploadImageTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostAddRequest;
use App\Http\Requests\PostEditRequest;

class AdminPostController extends Controller
{
    use UploadImageTrait;

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index(Request $request)
    {
        $keyword = '';
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $posts = $this->post->latest()->where('title', 'LIKE', "%{$keyword}%")->paginate(10);
        //Tổng số lượng bài viết
        $count_all = $this->post->count();
        //Tổng bài viết đã xóa tạm thời
        $count_trashed = $this->post->onlyTrashed()->count();
        $count = [$count_all, $count_trashed];
        return view('backend.post.index', compact('posts', 'count'));
    }

    public function create()
    {
        return view('backend.post.add');
    }

    public function store(PostAddRequest $request)
    {
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug ?? Str::slug($request->title),
            'user_id' => Auth::user()->id,
            'status' => $request->status
        ];

        $desc = $request->desc; //Mô tả ngắn
        if ($desc) {
            $data['desc'] = $desc;
        }
        //Ảnh đại diện
        $avatar = $this->uploadImage($request, 'avatar', 'post');
        if ($avatar) {
            $data['avatar'] = $avatar;
        }

        $this->post->create($data);
        return redirect()->route('admin.post.index')->with('toast_success', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $post = $this->post->find($id);
        return view('backend.post.edit', compact('post'));
    }

    public function update(PostEditRequest $request, $id)
    {
        $post = $this->post->find($id);
        $dataUpdate = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug ?? Str::slug($request->title),
            'status' => $request->status
        ];

        $desc = $request->desc;
        if ($desc) {
            $dataUpdate['desc'] = $desc;
        }

        $avatar = $this->uploadImage($request, 'avatar', 'post');
        if ($avatar) {
            $dataUpdate['avatar'] = $avatar;
        }

        $post->update($dataUpdate);
        return redirect()->route('admin.post.index')->with('toast_success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $post = $this->post->find($id);
        if ($post == NULL) {
            $this->post->onlyTrashed()->where('id', $id)->forceDelete(); //Xóa bản ghi trong thùng rác
            return response()->json([
                'post' => $post,
                'status' => true,
                'message' => 'ok'
            ]);
        }

        $post->delete();
        return response()->json([
            'post' => $post,
            'status' => true,
            'message' => 'ok'
        ]);
    }

    //===================== Tác vụ ============
    public function action(Request $request)
    {

        $listCheck = $request->post_id;
        if ($listCheck) {
            $action = $request->action;
            //=== Xóa tạm thời
            if ($action == 'destroy') {
                $this->post->destroy($listCheck);
                return back()->with('toast_success', 'Xóa bài viết thành công!');
            } elseif ($action == 'restore') {
                $this->post->onlyTrashed()->whereIn('id', $listCheck)->restore();
                return back()->with('toast_success', 'Khôi phục bài viết thành công!');
            } elseif ($action == 'forceDelete') {
                $this->post->onlyTrashed()->whereIn('id', $listCheck)->forceDelete();
                return back()->with('toast_success', 'Xóa vĩnh viễn bài viết thành công!');
            } else {
                return back()->with('status', 'Bạn cần phải trọn tác vụ để thực thi!');
            }
        } else {
            return back()->with('status', 'Bạn cần phải trọn phần tử để thực thi!');
        }
    }

    //=================== Thùng rác =============
    public function trashed(Request $request)
    {
        $keyword = '';
        if ($request->keyword) {
            $keyword = $request->keyword;
        }

        $posts = $this->post->onlyTrashed()->latest()
            ->where('title', 'LIKE', "%{$keyword}%")
            ->paginate(10);
        //Tổng số lượng bài viết
        $count_all = $this->post->count();
        //Tổng bài viết đã xóa tạm thời
        $count_trashed = $this->post->onlyTrashed()->count();
        $count = [$count_all, $count_trashed];
        return view('backend.post.list-trashed', compact('posts', 'count'));
    }

    //=================== Cập nhật trạng thái ẩn hiện bài viết ===============
    public function updateStatus(Request $request, $id)
    {
        $post = $this->post->find($id);
        if ($request->status == 'show') {
            $post->status = !$post->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $post->save();

            return response()->json([
                'status' => 'ok',
                'post' => $post,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/post/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $post->status = !$post->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $post->save();

        return response()->json([
            'status' => 'ok',
            'post' => $post,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/post/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);
    }
}
