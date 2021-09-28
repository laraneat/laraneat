<?php

namespace App\Modules\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Modules\User\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view-users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @param  \App\Modules\User\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->can('view-users');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create-users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @param  \App\Modules\User\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->can('update-users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @param  \App\Modules\User\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id === $model->id || $user->can('delete-users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @param  \App\Modules\User\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return $user->id === $model->id || $user->can('delete-users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Modules\User\Models\User  $user
     * @param  \App\Modules\User\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->can('force-delete-users');
    }
}
