<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAdminRequest;
use App\Http\Requests\UpdateAccountAdminRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    private $user;
    private $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        $admins = $this->user->get();
        return view('backend.user.index', compact('admins'));
    }

    public function create()
    {
        $roleAll = $this->role->all();
        return view('backend.user.add', compact('roleAll'));
    }

    public function store(AddAdminRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'active' => $request->active,
            'password' => Hash::make($request->password)
        ];

        $admin = $this->user->create($data);

        //Cách 1: dùng vòng lặp
    //    $roleIds = $request->role_id;
    //    foreach ($roleIds as $item) {
    //        DB::table('role_admin')->insert([
    //            'role_id' => $item,
    //            'admin_id' => $admin->id
    //        ]);
    //    }

        //Cách 2: dùng relationship laravel
        $admin->roles()->attach($request->role_id);

        return redirect()->route('admin.user.index')->with('toast_success', 'Thêm thành viên thành công!');
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $itemAdmin = $this->user->find($id);
            $roleAll = $this->role->all();
            $roleOfAdmin = $itemAdmin->roles;
            $data = view('backend.compoments.edit_admin', compact('itemAdmin', 'roleAll', 'roleOfAdmin'))->render();

            return response()->json([
                'data' => $data,
                'message' => 'ok'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $itemAdmin = $this->user->find($id);
        $itemAdmin->active = $request->active;
        $itemAdmin->save();
        $itemAdmin->roles()->sync($request->role_id);
        return redirect()->back()->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $itemAdmin = $this->user->find($id)->delete();
            DB::table('role_admin')->where('admin_id', $id)->delete();
            return response()->json([
                'itemAdmin' => $itemAdmin,
                'message' => 'ok'
            ]);
        }
    }

    //======== Thông tin tài khoản
    public function infoAccount($id)
    {
        $infoAccount = $this->user->find($id);
        return view('backend.user.info_account', compact('infoAccount'));
    }

    public function updateInfoAccount(UpdateAccountAdminRequest $request, $id)
    {
        $infoAccount = $this->user->find($id);
        $infoAccount->name = $request->name;
        $infoAccount->address = $request->address;
        $infoAccount->phone = $request->phone;
        if ($request->password) {
            $request->validate(
                [
                    'password' => 'min:6|max:32',
                    'password_confirm' => 'required|same:password',
                ],
                [
                    'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự!',
                    'password.max' => 'Mật khẩu tối đa 32 kí tự!',
                    'password_confirm.required' => 'Mật khẩu xác thực không được trống!',
                    'password_confirm.same' => 'Mật khẩu xác thực không đúng!',
                ]
            );
            $infoAccount->password = Hash::make($request->password);
        }
        $infoAccount->save();

        return redirect()->back()->with('toast_success', 'Cập nhật thành công!');
    }
}
