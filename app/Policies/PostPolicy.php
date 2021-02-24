<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
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
     * @param \App\Post $post
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->checkPermissionAcces('view_post');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->checkPermissionAcces('add_post');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Post $post
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->checkPermissionAcces('edit_post');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Post $post
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->checkPermissionAcces('delete_post');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Post $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Post $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
