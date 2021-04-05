<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Purchase_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPurchasePolicyController extends Controller
{
    private $purchase_policy;

    public function __construct(Purchase_policy $purchase_policy)
    {
        $this->purchase_policy = $purchase_policy;
    }

    public function index()
    {
        $purchasePolicy = $this->purchase_policy->all();
        return view('backend.purchase-policy.index', compact('purchasePolicy'));
    }

    public function create()
    {
        return view('backend.purchase-policy.add');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
            
                'title' => 'required|unique:purchase_policies',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tên tiêu đề không được trống!',
                'title.unique' => 'Tên tiêu đề không được trùng!',
                'content.required' => 'Nội dung không được trống!',
            ]
        );

        $data = [
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'status' => $request->status,
        ];

        $this->purchase_policy->create($data);
        return redirect()->route('admin.purchase_policy.index')->with('toast_success', 'Thêm chính sách thành công!');
    }

    public function edit(Request $request, $id)
    {
        $item = $this->purchase_policy->find($id);

        return view('backend.purchase-policy.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Tên tiêu đề không được trống!',
                'content.required' => 'Nội dung không được trống!',
            ]
        );

        $itemUpdate = $this->purchase_policy->find($id);

        $itemUpdate->title = $request->title;
        $itemUpdate->slug = $request->slug ?? Str::slug($request->title);
        $itemUpdate->content = $request->content;
        $itemUpdate->status = $request->status;

        $itemUpdate->save();

        return redirect()->route('admin.purchase_policy.index')->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $item = $this->purchase_policy->find($id)->delete();

            return response()->json([
                'status' => 'ok',
                'item' => $item
            ]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $item = $this->purchase_policy->find($id);

        if ($request->status == 'show') {
            $item->status = !$item->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $item->save();

            return response()->json([
                'status' => 'ok',
                'item' => $item,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/purchase-policy/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $item->status = !$item->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $item->save();

        return response()->json([
            'status' => 'ok',
            'item' => $item,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/purchase-policy/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);
    }
}
