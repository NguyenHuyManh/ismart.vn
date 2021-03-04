<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use App\Purchase_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('fontend.auth.login');
    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:32'
            ],
            [
                'email.required' => 'Email không được để trống!',
                'email.email' => 'Email không hợp lệ!',
                'password.required' => 'Mật khẩu không được để trống!',
                'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
                'password.max' => 'Mật khẩu tối đa 32 kí tự!',  
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ]);
        }

        if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'login' => 'success'
            ]);
        } else {
            return response()->json([
                'login' => 'error',
                'message' => 'Email hoặc mật khẩu không đúng!'
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return back();
    }
}
