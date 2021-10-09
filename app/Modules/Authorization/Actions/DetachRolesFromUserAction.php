<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\DetachRolesFromUserRequest;
use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as SpatieRole;

class DetachRolesFromUserAction extends Action
{
    public function handle(User $user, int|string|array|Collection|Role $roles): User
    {
        $user->roles()->detach($this->prepareRoles($roles));
        $user->forgetCachedPermissions();

        return $user;
    }

    protected function prepareRoles(int|string|array|Collection|Role $roles): array
    {
        return collect(Arr::wrap($roles))
            ->flatten()
            ->map(function ($role) {
                if (empty($role)) {
                    return false;
                }
                if (is_string($role)) {
                    return Role::findByName($role);
                }
                if (is_numeric($role)) {
                    return Role::findById($role);
                }

                return $role;
            })
            ->filter(function ($role) {
                return $role instanceof SpatieRole;
            })
            ->map->id
            ->all();
    }

    public function asController(DetachRolesFromUserRequest $request, User $user): UserResource
    {
        $roles = Arr::wrap($request->role_ids);

        return new UserResource(
            $this->handle($user, $roles)
        );
    }
}
