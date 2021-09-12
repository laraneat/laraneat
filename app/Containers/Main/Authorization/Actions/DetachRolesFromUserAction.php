<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\DetachRolesFromUserRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class DetachRolesFromUserAction extends Action
{
    /**
     * @param User $user
     * @param array<int|Role> $roles
     *
     * @return User
     */
    public function handle(User $user, $roles): User
    {
        $user->roles()->detach($roles);
        $user->forgetCachedPermissions();
        $user->load('roles');

        return $user;
    }

    /**
     * @param DetachRolesFromUserRequest $request
     *
     * @return UserResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function asController(DetachRolesFromUserRequest $request): UserResource
    {
        $user = User::findOrFail($request->user_id);
        $roles = Arr::wrap($request->role_ids);

        return new UserResource($this->handle($user, $roles));
    }
}
