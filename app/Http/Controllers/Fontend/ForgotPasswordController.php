<?php

namespace App\Http\Controllers\Fontend;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Purchase_policy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\UserResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    // Form gửi email reset pass
    public function getFormResetPassword()
    {

        return view('fontend.auth.passwords.email');
    }

    //Gửi email
    public function sendMailRessetPassword(Request $request)
    {
        $request->validate(
            ['email' => 'required|email:rfc,dns'],
            [
                'email.required' => "Email không được để trống!",
                'email.email' => "Email không đúng định dạng!"
            ]
        );

        //Kiểm tra email có tồn tại trong CSDL k
        $email = $request->email;
        $checkEmail = $this->customer->where('email', $email)->first();
        if (!$checkEmail) {
            return back()->with('error', 'Email không tồn tại trên hệ thống. Vui lòng nhập lại!');
        }

        //Lưu mã token vào CSDl
        $token = Str::random(40) . md5($email);
        $time_token = Carbon::now();
        $time_end = Carbon::now()->addMinutes(30); //Thời hạn cho phép reset password
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => $time_token,
            'time_end' => $time_end
        ]);

        $url = route('link.reset_password', ['token' => $token, 'email' => $email]);
        $data = [
            'route' => $url,
        ];

        Mail::to($email)->send(new UserResetPassword($data));
        return back()->with('status', 'Đường dẫn lấy lại mật khẩu đã được gửi vào email của bạn!');
    }

    //Form reset pass
    public function resetPassword(Request $request)
    {
        //=============
        $token = $request->token;
        $email = $request->email;
        $check = DB::table('password_resets')->where([
            ['email', $email],
            ['token', $token]
        ])->first();

        if (!$check) {
            return redirect()->route('get.form.reset_password')->with('status', 'Đường dẫn lấy lại mật khẩu không đúng, vui lòng thử lại!');
        }

        //Kiểm tra thời gian cho phép reset password
        $time_now = Carbon::now()->toDateTimeString();
        $checkTime = DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->where('time_end', '>=', $time_now)->first();

        if ($checkTime == Null) {
            DB::table('password_resets')
                ->where([
                    ['token', $token],
                    ['email', $email]
                ])
                ->delete();

            return redirect()->route('get.form.reset_password')->with('status', 'Đã quá thời hạn cho phép, vui lòng thử lại!');
        } else {
            return view('fontend.auth.passwords.reset');
        }
    }

    //Lưu mật khẩu mới
    public function saveResetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'required|min:6|max:32',
                'password_confirmation' => 'required|same:password'

            ],
            [
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
                'password.max' => 'Mật khẩu tối đa 32 kí tự!',
                'password_confirmation.required' => 'Mật khẩu xác thực không được để trống',
                'password_confirmation.same' => 'Mật khẩu xác thực không đúng!'
            ]
        );

        $token = $request->token;
        $email = $request->email;
        $check = DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->first();

        if (!$check) {
            return redirect()->route('get.form.reset_password')->with('status', 'Đường dẫn lấy lại mật khẩu không đúng, vui lòng thử lại!');
        }

        //Lưu mật khẩu mới
        $updatePassword = Hash::make($request->password);
        $this->customer->where('email', $email)->update(['password' => $updatePassword]);

        //Xóa token
        DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->delete();

        return redirect('/login')->with('status', 'Mật khẩu của bạn đã được đặt lại!');
    }
}
