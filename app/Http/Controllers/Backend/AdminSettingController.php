<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Setting;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    use UploadImageTrait;

    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $item = $this->setting->find(1);

        return view('backend.setting.index', compact('item'));
    }

    public function update(Request $request)
    {
        $setting = $this->setting->find(1);
        $logo = $this->uploadImage($request, 'logo', 'logo');
        if($logo)
        {
            $setting->logo = $logo;
        }
        $setting->slogan = $request->slogan;
        $setting->copyright = $request->copyright;
        $setting->fanpage = $request->fanpage;
        $setting->address = $request->address;
        $setting->phone = $request->phone;
        $setting->email = $request->email;
        $setting->save();

        return redirect()->route('admin.setting.index')->with('toast_success', 'Lưu thành công!');
    }
}
