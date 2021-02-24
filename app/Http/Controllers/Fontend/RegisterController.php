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

class RegisterController extends Controller
{
    public function register()
    {
        return view('fontend.auth.register');
    }

    public function postRegister(RegisterUserRequest $request)
    {
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
                return redirect('/');
            }
        }
    }
}
