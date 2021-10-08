<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\DetachPermissionsFromRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission as SpatiePermission;

class DetachPermissionsFromRoleAction extends Action
{
    /**
     * @param Role $role
     * @param int|string|Permission|array|\Illuminate\Support\Collection $permissions
     *
     * @return Role
     */
    public function handle(Role $role, $permissions): Role
    {
        $role->permissions()->detach($this->preparePermissions($permissions));
        $role->forgetCachedPermissions();

        return $role;
    }

    /**
     * @param int|string|Permission|array|\Illuminate\Support\Collection $permissions
     *
     * @return Permission[]
     */
    public function preparePermissions($permissions): array
    {
        return collect(Arr::wrap($permissions))
            ->flatten()
            ->map(function ($permission) {
                if (empty($permission)) {
                    return false;
                }
                if (is_string($permission)) {
                    return Permission::findByName($permission);
                }
                if (is_numeric($permission)) {
                    return Permission::findById($permission);
                }

                return $permission;
            })
            ->filter(function ($permission) {
                return $permission instanceof SpatiePermission;
            })
            ->map->id
            ->all();
    }

    /**
     * @param DetachPermissionsFromRoleRequest $request
     * @param Role $role
     *
     * @return RoleResource
     */
    public function asController(DetachPermissionsFromRoleRequest $request, Role $role): RoleResource
    {
        $permissions = Arr::wrap($request->permissions_ids);

        return new RoleResource(
            $this->handle($role, $permissions)
        );
    }
}
