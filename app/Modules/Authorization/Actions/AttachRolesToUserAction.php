<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\AttachRolesToUserRequest;
use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AttachRolesToUserAction extends Action
{
    public function handle(User $user, int|string|array|Collection|Role $roles): User
    {
        return $user->assignRole($roles);
    }

    public function asController(AttachRolesToUserRequest $request, User $user): UserResource
    {
        return new UserResource(
            $this->handle($user, Arr::wrap($request->role_ids))
        );
    }
}
