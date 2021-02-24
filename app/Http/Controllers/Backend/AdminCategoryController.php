<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Compoments\CategoryRecusive;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\StoreCategoryAdd;

class AdminCategoryController extends Controller
{
    private $categoryRecusive;
    private $category;

    public function __construct(CategoryRecusive $categoryRecusive, Category $category)
    {
        $this->categoryRecusive = $categoryRecusive;
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $data = $this->category->all(); //Lấy tất cả danh mục
        $categorys = data_tree($data);

        return view('backend.category.index', compact('categorys'));
    }

    public function create()
    {
        $htmlSelect = $this->categoryRecusive->categoryRecusiveAdd();
        return view('backend.category.add', compact('htmlSelect'));
    }

    public function store(CategoryAddRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'meta_title' => $request->meta_title ? $request->meta_title : $request->name
        ];

        if ($request->meta_desc) {
            $data['meta_desc'] = $request->meta_desc;
        }

        if ($request->meta_keyword) {
            $data['meta_keyword'] = $request->meta_keyword;
        }

        $this->category->create($data);
        return redirect()->route('admin.category.create')->with('toast_success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = $this->category->find($id);
        $htmlSelect = $this->categoryRecusive->categoryRecusiveEdit($category->parent_id); //Selected danh mục cần edit
        return view('backend.category.edit', compact('htmlSelect', 'category'));
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $dataUpdate = [
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'meta_title' => $request->meta_title ? $request->meta_title : $request->name
        ];

        if ($request->meta_desc) {
            $dataUpdate['meta_desc'] = $request->meta_desc;
        }

        if ($request->meta_keyword) {
            $dataUpdate['meta_keyword'] = $request->meta_keyword;
        }

        $this->category->where('id', $id)->update($dataUpdate);
        return redirect()->route('admin.category.index')->with('toast_success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(Request $request, $id)
    {
        $data = $this->category->get(); //Lấy ra tất cả bản ghi
        $category = $this->category->find($id);

        foreach ($data as $item) {
            if ($item['parent_id'] == $category['id']) {
                return response()->json([
                    'category' => $category,
                    'status' => false,
                    'message' => "Bạn cần xóa các danh mục con trước!"
                ]);
            }
            //Đếm sản phẩm thuộc danh mục
            $count = Product::where('category_id', $id)->count();
            if ($count > 0) {
                return response()->json([
                    'category' => $category,
                    'status' => false,
                    'message' => "Bạn cần xóa các sản phẩm thuộc danh mục trước!"
                ]);
            }
        }

        $category->delete();
        return response()->json([
            'category' => $category,
            'status' => true,
            'message' => 'ok'
        ]);
    }

    //================== Cập nhật trạng thái ẩn - hiện danh mục ==============
    public function updateStatus(Request $request, $id)
    {
        $category = $this->category->find($id);
        if ($request->status == 'show') {
            $category->status = !$category->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $category->save();

            return response()->json([
                'status' => 'ok',
                'category' => $category,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/category/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $category->status = !$category->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $category->save();

        return response()->json([
            'status' => 'ok',
            'category' => $category,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/category/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);
    }
}
