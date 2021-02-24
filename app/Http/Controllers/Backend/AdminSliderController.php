<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Slider;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class AdminSliderController extends Controller
{
    use UploadImageTrait;

    private $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {
        $sliders = $this->slider->latest()->paginate(5);
        return view('backend.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.slider.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $imageSlider = $this->uploadImage($request, 'image', 'slider');

        $this->slider->create([
            'image' => $imageSlider,
            'status' => $request->status
        ]);
        return redirect()->route('admin.slider.index')->with('toast_success', 'Thêm slider thành công!');
    }

    public function edit($id)
    {
        $slider = $this->slider->find($id);

        return view('backend.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $sliderUpdate = $this->slider->find($id);
        $dataUpdate = [
            'status' => $request->status
        ];

        $imageSliderUpdate = $this->uploadImage($request, 'image', 'slider');
        if (!empty($imageSliderUpdate)) {
            $dataUpdate['image'] = $imageSliderUpdate;
        }

        $sliderUpdate->update($dataUpdate);
        return redirect()->route('admin.slider.index')->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $slider = $this->slider->find($id);
            $filePath = $slider->image;
            unlink($filePath);
            $slider->delete();

            return response()->json([
                'slider' => $slider,
                'message' => 'ok'
            ]);
        }
    }

    //================== Cập nhật trạng thái ẩn - hiện Slider ==============
    public function updateStatus(Request $request, $id)
    {
        $slider = $this->slider->find($id);
        if ($request->status == 'show') {
            $slider->status = !$slider->status; //Nếu status = 1 => 0, nếu = 0 => 1
            $slider->save();

            return response()->json([
                'status' => 'ok',
                'slider' => $slider,
                'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/slider/update-status/' . $id . '"
                                           class="badge badge-danger update-status" data-status="hiden"
                                           style="padding: 10px 26px; font-size: 13px;border-radius: 1.25rem !important">Ẩn</a>'
            ]);
        }

        $slider->status = !$slider->status; //Nếu status = 1 => 0, nếu = 0 => 1
        $slider->save();

        return response()->json([
            'status' => 'ok',
            'slider' => $slider,
            'html' => '<a href="http://localhost:8080/Laravel/ismart.vn/admin/slider/update-status/' . $id . '"
                                           class="badge badge-success update-status" data-status="show"
                                           style="padding: 10px 10px; font-size: 13px; border-radius: 1.25rem !important">Hiển thị</a>'
        ]);
    }
}
