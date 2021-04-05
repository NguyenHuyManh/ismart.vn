<?php

namespace App\Http\Controllers\Fontend;

use App\Customer;
use App\Purchase_policy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('fontend.auth.register');
    }

    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email:rfc,dns|unique:customers',
                'phone' => 'required|numeric|digits:10|unique:customers',
                'password' => 'required|min:6|max:32',
                'password_confirmation' => 'required|same:password'
            ],
            [
                'name.required' => 'Họ tên không được để trống!',
                'email.required' => 'Email không được để trống!',
                'email.email' => 'Email không đúng định dạng!',
                'email.unique' => 'Email đã được đăng kí!',
                'password.required' => 'Mật khẩu không được để trống!',
                'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
                'password.max' => 'Mật khẩu tối đa 32 kí tự!',
                'phone.required' => 'Số điện thoại không được để trống!',
                'phone.numeric' => 'Số điện thoại phải là chữ số!',
                'phone.digits' => 'Số điện thoại phải có 10 chữ số!',
                'phone.unique' => 'Số điện thoại đã được đăng kí!',
                'password_confirmation.required' => 'Mật khẩu xác thực không được trống!',
                'password_confirmation.same' => 'Mật khẩu xác thực không đúng!' 
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now()
        ];

        $userId = Customer::insertGetId($data);
        if ($userId) {
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                // return redirect('/');
                return response()->json([
                    'register' => 'success'
                ]);
            }
        }
    }
}
