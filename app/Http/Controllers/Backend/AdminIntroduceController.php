<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Introduce;
use Illuminate\Http\Request;

class AdminIntroduceController extends Controller
{
    private $introduce;
    public function __construct(Introduce $introduce)
    {
        $this->introduce = $introduce;
    }
    
    public function index()
    {
        $introduce = $this->introduce->find(1);
        return view('backend.intro.index', compact('introduce'));
    }

    public function update(Request $request)
    {
        $introduce = $this->introduce->find(1);
        $introduce->content = $request->content; //Lưu nội dung trang giới thiệu
        $introduce->save();
        return back()->with('toast_success', 'Lưu thành công!');   
    }
}
