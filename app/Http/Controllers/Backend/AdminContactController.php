<?php

namespace App\Http\Controllers\Backend;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    private $contact;
    public function __construct(Contact $contact)
    {
        $this->contact =$contact;
    }

    public function index()
    {
        $contact = $this->contact->find(1);
        return view('backend.contact.index', compact('contact'));
    }

    public function update(Request $request)
    {
        $contact = $this->contact->find(1);
        $contact->info_contact = $request->info_contact; //Lưu thông tin liên hệ
        $contact->info_map = $request->info_map; //Lưu bản đồ
        $contact->save();
        return back()->with('toast_success', 'Lưu thành công!');
    }
}
