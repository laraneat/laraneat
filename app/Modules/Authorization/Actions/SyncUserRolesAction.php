<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SyncUserRolesAction extends Action
{
    public function handle(User $user, int|string|array|Collection|Role $roles): User
    {
        return $user->syncRoles($roles);
    }

    public function asController(SyncUserRolesRequest $request, User $user): UserResource
    {
        $roles = Arr::wrap($request->role_ids);

        return new UserResource($this->handle($user, $roles));
    }
}
