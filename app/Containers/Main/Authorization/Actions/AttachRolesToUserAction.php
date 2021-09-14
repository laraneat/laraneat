<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\AttachRolesToUserRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class AttachRolesToUserAction extends Action
{
    /**
     * @param User $user
     * @param int|string|Role|array|\Illuminate\Support\Collection $roles
     *
     * @return User
     */
    public function handle(User $user, $roles): User
    {
        return $user->assignRole($roles);
    }

    /**
     * @param AttachRolesToUserRequest $request
     *
     * @return UserResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function asController(AttachRolesToUserRequest $request): UserResource
    {
        $user = User::findOrFail($request->user_id);
        $roles = Arr::wrap($request->role_ids);

        return new UserResource(
            $this->handle($user, $roles)
        );
    }
}
