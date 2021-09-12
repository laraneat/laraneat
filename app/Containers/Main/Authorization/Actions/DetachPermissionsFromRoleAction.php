<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\DetachPermissionsFromRoleRequest;
use App\Ship\Abstracts\Actions\Action;

class DetachPermissionsFromRoleAction extends Action
{
    /**
     * Detach permission(s) from a role.
     *
     * @param Role $role
     * @param string|Permission|array $permissions
     *
     * @return Role
     */
    public function handle(Role $role, ...$permissions): Role
    {
        $role->revokePermissionTo($permissions);

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
        $permissions = (array) $request->permissions_ids;

        return $this->handle($role, $permissions);
    }
}
