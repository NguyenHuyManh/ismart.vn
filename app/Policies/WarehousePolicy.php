<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return $user->checkPermissionAcces('view_warehouse');
    }

    public function update(User $user)
    {
        return $user->checkPermissionAcces('update_warehouse');
    }
}
