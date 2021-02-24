<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'active', 'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_admin', 'admin_id', 'role_id');
    }

//    //Check quyền truy cập
    public function checkPermissionAcces($keyCode)
    {
        //B1:Lấy ra tất cả các vai trò của admin login
        $roles = Auth::user()->roles;

        //B2:So sách các quyền lấy được ở B1 của route hiện hành có khớp với keycode chuyền sang k
        foreach ($roles as $role) {
            $permissions = $role->permissions;

            if ($permissions->contains('key_code', $keyCode)) {
                return true;
            }
        }
        return false;
    }
}
