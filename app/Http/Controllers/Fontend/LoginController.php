<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Purchase_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function login()
    {
        return view('fontend.auth.login');
    }

    public function postLogin(LoginUserRequest $request)
    {
        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        } else {
            return back()->with('error', 'Email hoặc mật khẩu không đúng!');
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return back();
    }
}
