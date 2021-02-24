<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Carbon\Carbon;
use App\Mail\AdminResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminForgotPasswordController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //Form gửi mail reset pass
    public function getFormResetPassword()
    {
        return view('backend.auth.passwords.email');
    }

    //Gửi mail
    public function sendMailResetPassword(Request $request)
    {
        $request->validate(
            ['email' => 'required'],
            ['email.required' => "Email không được để trống!"]
        );

        //Kiểm tra email có tồn tại trong CSDL k
        $email = $request->email;
        $checkUser = $this->user->where('email', $email)->first();
        if (!$checkUser) {
            return back()->with('status', 'Email không tồn tại trên hệ thống. Vui lòng nhập lại!');
        }

        //Lưu mã token vào CSDl
        $token = Str::random(40) . md5($email); //Mã token
        $time_token = Carbon::now(); //Thời gian gửi yêu cầu
        $time_end = Carbon::now()->addMinutes(1); //Thời hạn cho phép reset password
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => $time_token,
            'time_end' => $time_end
        ]);

        $url = route('admin.link.reset.password', ['token' => $token, 'email' => $email]);
        $data = [
            'route' => $url,
        ];

        Mail::to($email)->send(new AdminResetPassword($data));
        return back()->with('status', 'Đường dẫn lấy lại mật khẩu đã được gửi vào email của bạn!');
    }

    //Form đặt lại pass
    public function resetPassword(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        //Kiểm tra xem email và mã token có khớp mà đã giữ qua email k
        $checkUser = DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->first();

        if (!$checkUser) {
            return redirect()->route('admin.send.reset.password')->with('status', 'Đường dẫn lấy lại mật khẩu không đúng, vui lòng thử lại!');
        }

        //Kiểm tra thời gian cho phép reset password
        $time_now = Carbon::now()->toDateTimeString();
        $checkTime = DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->where('time_end', '>=', $time_now)->first();

        if($checkTime == Null)
        {
            DB::table('password_resets')
                ->where([
                    ['token', $token],
                    ['email', $email]
                ])
                ->delete();

            return redirect()->route('admin.send.reset.password')->with('status', 'Đã quá thời hạn cho phép, vui lòng thử lại!');
        }else{
            return view('backend.auth.passwords.reset');
        }


    }

    public function saveResetPassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'required',
                'password_comfirm' => 'required|same:password'

            ],
            [
                'password.required' => 'Mật khẩu không được để trống',
                'password_comfirm.required' => 'Mật khẩu xác thực không được để trống',
                'password_comfirm.same' => 'Mật khẩu xác thực không đúng!'
            ]
        );

        $token = $request->token;
        $email = $request->email;
        $checkUser = DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->first();

        if (!$checkUser) {
            return redirect()->route('admin.send.reset.password')->with('status', 'Đường dẫn lấy lại mật khẩu không đúng, vui lòng thử lại!');
        }

        //Lưu mật khẩu mới
        $updatePassword = Hash::make($request->password);
        $this->user->where('email', $email)->update(['password' => $updatePassword]);

        //Xóa token
        DB::table('password_resets')
            ->where([
                ['token', $token],
                ['email', $email]
            ])->delete();

        return redirect('admin/login')->with('status', 'Mật khẩu của bạn đã được đặt lại!');
    }
}
