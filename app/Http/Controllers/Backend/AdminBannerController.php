<?php

namespace App\Http\Controllers\Backend;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    use UploadImageTrait;

    private $banner;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        $banners = $this->banner->latest()->get();
        return view('backend.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $imageBanner = $this->uploadImage($request, 'image', 'banner');
        
        $this->banner->create([
            'image' => $imageBanner,
            'status' => $request->status
        ]);

        return redirect()->route('admin.banner.index')->with('toast_success', 'Thêm slider thành công!');
    }

    public function edit($id)
    {
        $banner = $this->banner->find($id);
        return view('backend.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $bannerUpdate = $this->banner->find($id);
        $dataUpdate = [
            'status' => $request->status
        ];

        $imageBannerUpdate = $this->uploadImage($request, 'image', 'banner');
        if (!empty($imageBannerUpdate)) {
            $dataUpdate['image'] = $imageBannerUpdate;
        }

        $bannerUpdate->update($dataUpdate);
        return redirect()->route('admin.banner.index')->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $banner = $this->banner->find($id);
            $filePath = $banner->image;
            unlink($filePath);
            $banner->delete();

            return response()->json([
                'banner' => $banner,
                'message' => 'ok'
            ]);
        }
    }

    //================== Cập nhật trạng thái ẩn - hiện Banner ==============
    public function updateStatus(Request $request,$id)
    {
        $banner = $this->banner->find($id);
        if ($request->status == 'show') {
            $banner->status = !$banner->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $banner->save();

            return response()->json([
                'status' => 'ok',
                'banner' => $banner,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/banner/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $banner->status = !$banner->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $banner->save();

        return response()->json([
            'status' => 'ok',
            'banner' => $banner,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/banner/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);
    }
}
