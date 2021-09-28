<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\AttachRolesToUserRequest;
use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Resources\UserResource;
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
     * @param User $user
     *
     * @return UserResource
     */
    public function asController(AttachRolesToUserRequest $request, User $user): UserResource
    {
        $roles = Arr::wrap($request->role_ids);

        return new UserResource(
            $this->handle($user, $roles)
        );
    }
}
