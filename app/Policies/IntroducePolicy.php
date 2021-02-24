<?php

namespace App\Policies;

use App\Introduce;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntroducePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Introduce $introduce
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->checkPermissionAcces('view_introduce');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Introduce $introduce
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->checkPermissionAcces('update_introduce');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Introduce $introduce
     * @return mixed
     */
    public function delete(User $user, Introduce $introduce)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Introduce $introduce
     * @return mixed
     */
    public function restore(User $user, Introduce $introduce)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Introduce $introduce
     * @return mixed
     */
    public function forceDelete(User $user, Introduce $introduce)
    {
        //
    }
}
