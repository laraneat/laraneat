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
                return $role instanceof Role;
            })
            ->map->id
            ->all();
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

        return new UserResource(
            $this->handle($user, $roles)
        );
    }
}
