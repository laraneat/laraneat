<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\DetachPermissionsFromRoleRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class DetachPermissionsFromRoleAction extends Action
{
    /**
     * @param Role $role
     * @param array<int|Permission> $permissions
     *
     * @return Role
     */
    public function handle(Role $role, $permissions): Role
    {
        $role->permissions()->detach($permissions);
        $role->forgetCachedPermissions();
        $role->load('permissions');

        return $role;
    }

    /**
     * @param DetachPermissionsFromRoleRequest $request
     *
     * @return Role
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function asController(DetachPermissionsFromRoleRequest $request): Role
    {
        $role = Role::findOrFail($request->role_id);
        $permissions = Arr::wrap($request->permissions_ids);

        return $this->handle($role, $permissions);
    }
}
