<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class SyncUserRolesAction extends Action
{
    /**
     * @param User $user
     * @param int|string|Role|array|\Illuminate\Support\Collection $roles
     *
     * @return User
     */
    public function handle(User $user, $roles): User
    {
        return $user->syncRoles($roles);
    }

    /**
     * @param SyncUserRolesRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function asController(SyncUserRolesRequest $request, User $user): UserResource
    {
        $roles = Arr::wrap($request->role_ids);

        return new UserResource($this->handle($user, $roles));
    }
}
