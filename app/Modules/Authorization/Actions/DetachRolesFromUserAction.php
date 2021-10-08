<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\DetachRolesFromUserRequest;
use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role as SpatieRole;

class DetachRolesFromUserAction extends Action
{
    /**
     * @param User $user
     * @param int|string|Role|array|\Illuminate\Support\Collection $roles
     *
     * @return User
     */
    public function handle(User $user, $roles): User
    {
        $user->roles()->detach($this->prepareRoles($roles));
        $user->forgetCachedPermissions();

        return $user;
    }

    /**
     * @param int|string|Role|array|\Illuminate\Support\Collection $roles
     *
     * @return Role[]
     */
    protected function prepareRoles($roles): array
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

    /**
     * @param DetachRolesFromUserRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function asController(DetachRolesFromUserRequest $request, User $user): UserResource
    {
        $roles = Arr::wrap($request->role_ids);

        return new UserResource(
            $this->handle($user, $roles)
        );
    }
}
