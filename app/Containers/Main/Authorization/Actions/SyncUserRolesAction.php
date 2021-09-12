<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Spatie\Permission\Contracts\Role;

class SyncUserRolesAction extends Action
{
    /**
     * @param User $user
     * @param string|int|Role|array|\Illuminate\Support\Collection ...$roles
     *
     * @return User
     */
    public function handle(User $user, ...$roles): User
    {
        return $user->syncRoles($roles);
    }

    /**
     * @param SyncUserRolesRequest $request
     *
     * @return UserResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function asController(SyncUserRolesRequest $request): UserResource
    {
        $user = User::findOrFail($request->user_id);
        $roles = (array) $request->role_ids;

        return new UserResource($this->handle($user, $roles));
    }
}
