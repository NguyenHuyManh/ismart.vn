<?php

namespace App\Http\Controllers\Backend;

use App\Product;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Compoments\CategoryRecusive;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product_image;

class AdminProductController extends Controller
{
    use UploadImageTrait;

    private $categoryRecusive;
    private $product;
    private $product_image;

    public function __construct(CategoryRecusive $categoryRecusive, Product $product, Product_image $product_image)
    {
        $this->categoryRecusive = $categoryRecusive;
        $this->product = $product;
        $this->product_image = $product_image;
    }

    public function index(Request $request)
    {
        $keyword = '';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }

        $products = $this->product->latest()->where('name', 'LIKE', "%{$keyword}%")->paginate(20);
        $count_all = $this->product->count(); //All
        $count_trashed = $this->product->onlyTrashed()->count(); //Số lượng bản ghi xóa tạm thời
        $count = [$count_all, $count_trashed];

        return view('backend.product.index', compact('products', 'count'));
    }

    public function create()
    {
        $htmlSelect = $this->categoryRecusive->categoryRecusiveAdd(); //Lấy danh mục
        return view('backend.product.add', compact('htmlSelect'));
    }

    public function store(ProductAddRequest $request)
    {
        $dataProduct = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => str_replace(',', '', $request->price),
            'discount' => str_replace(',', '', $request->discount),
            'amount' => $request->amount,
            'content' => $request->content,
            'desc' => $request->desc,
            'slug' => $request->slug ?? Str::slug($request->name),
            'user_id' => Auth::user()->id,
            'status' => $request->status,
            'highlight' => $request->highlight,
            'meta_title' => $request->meta_title ?? $request->name
        ];

        if ($request->meta_desc) {
            $dataProduct['meta_desc'] = $request->meta_desc;
        }

        if ($request->meta_keyword) {
            $dataProduct['meta_keyword'] = $request->meta_keyword;
        }

        //Gọi phương thức uploadImage ở lớp trait
        $filePath = $this->uploadImage($request, 'avatar', 'product');
        $dataProduct['avatar'] = $filePath;
        $product = $this->product->create($dataProduct);

        //Upload ảnh chi tiết
        if ($request->hasFile('image_detail')) {
            foreach ($request->image_detail as $imageItem) {
                $fileName = Str::random(20) . '-' . $imageItem->getClientOriginalName();
                $filePath = $imageItem->move('public/uploads/product', $fileName);

                $this->product_image->create([
                    'product_id' => $product->id,
                    'image_detail' => $filePath
                ]);
            }
        }

        return back()->with('toast_success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = $this->product->find($id);

        $htmlSelect = $this->categoryRecusive->categoryRecusiveEdit($product->category_id); //Selected danh mục
        return view('backend.product.edit', compact('product', 'htmlSelect'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = $this->product->find($id);
        $dataUpdate = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => str_replace(',', '', $request->price),
            'discount' => str_replace(',', '', $request->discount),
            'amount' => $request->amount,
            'content' => $request->content,
            'desc' => $request->desc,
            'slug' => $request->slug ?? Str::slug($request->name),
            'status' => $request->status,
            'highlight' => $request->highlight,
            'meta_title' => $request->meta_title ?? $request->name
        ];

        if ($request->meta_desc) {
            $dataUpdate['meta_desc'] = $request->meta_desc;
        }

        if ($request->meta_keyword) {
            $dataUpdate['meta_keyword'] = $request->meta_keyword;
        }

        $filePath = $this->uploadImage($request, 'avatar', 'product');

        if (!empty($filePath)) {
            $dataUpdate['avatar'] = $filePath;
        }

        $product->update($dataUpdate);
        // $product = $this->product->find($id);

        if ($request->hasFile('image_detail')) {
            //Xóa tất cả những ảnh chi tiết đang có
            $this->product_image->where('product_id', $id)->delete();
            //Thêm mới lại
            foreach ($request->image_detail as $imageItem) {
                $fileName = Str::random(20) . '-' . $imageItem->getClientOriginalName();
                $filePath = $imageItem->move('public/uploads/product', $fileName);

                $this->product_image->create([
                    'product_id' => $product->id,
                    'image_detail' => $filePath
                ]);
            }
        }

        return redirect()->back()->with('toast_success', 'Cập nhập sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = $this->product->find($id);
        if ($product == Null) {
            $this->product->onlyTrashed()->where('id', $id)->forceDelete();
            return response()->json([
                'product' => $product,
                'status' => true,
                'message' => 'ok'
            ]);
        }

        $product->delete();
        return response()->json([
            'product' => $product,
            'status' => true,
            'message' => 'ok'
        ]);
    }

    //============================ Thùng rác =============================
    public function trashed(Request $request)
    {
        $keyword = '';
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }

        $products = $this->product->onlyTrashed()->latest()->where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        $count_all = $this->product->count();
        $count_trashed = $this->product->onlyTrashed()->count();
        $count = [$count_all, $count_trashed];
        return view('backend.product.list-trashed', compact('products', 'count'));
    }

    //================================ Tác vụ ==========================
    public function action(Request $request)
    {
        $listCheck = $request->input('product_id'); //Danh sách id sản phẩm cần thực thi
        if ($listCheck) {
            $action = $request->input('action'); //Lấy action muốn thực thi
            if ($action == 'destroy') {
                $this->product->destroy($listCheck);
                return back()->with('toast_success', 'Xóa sản phẩm thành công!');
            } elseif ($action == 'restore') {
                $this->product->onlyTrashed()->whereIn('id', $listCheck)->restore();
                return back()->with('toast_success', 'Khôi phục sản phẩm thành công!');
            } elseif ($action == 'forceDelete') {
                $this->product->onlyTrashed()->whereIn('id', $listCheck)->forceDelete();
                return back()->with('toast_success', 'Xóa vĩnh viễn sản phẩm thành công!');
            } else {
                return back()->with('status', 'Bạn cần chọn tác vụ để thực thi!');
            }
        } else {
            return back()->with('status', 'Bạn cần chọn phần tử để thực thi!');
        }
    }

    //================== Cập nhật trạng thái ẩn - hiện sản phẩm ==============
    public function updateStatus(Request $request,$id)
    {
        $product = $this->product->find($id);
        if($request->status == 'show'){
            $product->status = !$product->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $product->save();

            return response()->json([
                'status' => 'ok',
                'product' => $product,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/product/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $product->status = !$product->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $product->save();

        return response()->json([
            'status' => 'ok',
            'product' => $product,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/product/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);

    }

    //================== Cập nhật nổi bật sản phẩm ==============
    public function updateHighlight(Request $request, $id)
    {
        $product = $this->product->find($id);
        if($request->highlight == 'yes'){
            $product->highlight = !$product->highlight; //Nếu highlight = 1 => 0, nếu = 0 => 1
            $product->save();

            return response()->json([
                'status' => 'ok',
                'product' => $product,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/product/update-highlight/' . $id . '"
                                class="badge badge-danger update-highlight" data-type_highlight="no"
                                style="padding: 10px 13px; font-size: 13px;border-radius: 1.25rem !important">Không</a>'
            ]);
        }

        $product->highlight = !$product->highlight; //Nếu highlight = 1 => 0, nếu = 0 => 1
        $product->save();

        return response()->json([
            'status' => 'ok',
            'product' => $product,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/product/update-highlight/' . $id . '"
                    class="badge badge-success update-highlight" data-type_highlight="yes"
                    style="padding: 10px 10px; font-size: 13px;border-radius: 1.25rem !important">Nổi
                    bật</a>'
        ]);
    }

    // public function paginateAjax(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $products = $this->product->paginate(20);
    //         return view('backend.compoments.paginate_ajax_product', compact('products'))->render();
    //     }
    // }
}
