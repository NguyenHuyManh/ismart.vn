<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRoleRequest;
use App\Http\Requests\EditRoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $roles = $this->role->paginate(10);
        return view('backend.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permission->where('parent_id', 0)->get();
        return view('backend.roles.add', compact('permissions'));
    }

    public function store(AddRoleRequest $request)
    {
        $role = $this->role->create([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);

        $role->permissions()->attach($request->permission_id);

        return redirect()->route('admin.role.index')->with('toast_success', 'Thêm thành công!');
    }

    public function edit($id)
    {
        $permissions = $this->permission->where('parent_id', 0)->get();
        $role = $this->role->find($id);
        $permissionChecked = $role->permissions;

        return view('backend.roles.edit', compact('role', 'permissions', 'permissionChecked'));
    }

    public function update(EditRoleRequest $request, $id)
    {
        $roleUpdate = $this->role->find($id);
        $roleUpdate->update([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);
        $roleUpdate->permissions()->sync($request->permission_id);

        return redirect()->route('admin.role.index')->with('toast_success', 'Cập nhật thành công!');
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $role = $this->role->find($id)->delete();
            DB::table('permission_role')->where('role_id', $id)->delete();
            
            return response()->json([
                'role' => $role,
                'message' => 'ok'
            ]);
        }
    }
}
