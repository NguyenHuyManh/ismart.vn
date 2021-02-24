<?php

namespace App\Policies;

use App\Purchase_policy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Purchase_policy  $purchasePolicy
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->checkPermissionAcces('view_purchase');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkPermissionAcces('add_purchase');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Purchase_policy  $purchasePolicy
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->checkPermissionAcces('edit_purchase');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Purchase_policy  $purchasePolicy
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAcces('delete_purchase');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Purchase_policy  $purchasePolicy
     * @return mixed
     */
    public function restore(User $user, Purchase_policy $purchasePolicy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Purchase_policy  $purchasePolicy
     * @return mixed
     */
    public function forceDelete(User $user, Purchase_policy $purchasePolicy)
    {
        //
    }
}
