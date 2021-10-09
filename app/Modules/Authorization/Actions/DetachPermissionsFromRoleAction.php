<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\DetachPermissionsFromRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission as SpatiePermission;

class DetachPermissionsFromRoleAction extends Action
{
    public function handle(Role $role, int|string|array|Collection|Permission $permissions): Role
    {
        $role->permissions()->detach($this->preparePermissions($permissions));
        $role->forgetCachedPermissions();

        return $role;
    }

    /**
     * @return Permission[]
     */
    public function preparePermissions(int|string|array|Collection|Permission $permissions): array
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

    public function asController(DetachPermissionsFromRoleRequest $request, Role $role): RoleResource
    {
        $permissions = Arr::wrap($request->permission_ids);

        return new RoleResource(
            $this->handle($role, $permissions)
        );
    }
}
