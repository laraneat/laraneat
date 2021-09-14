<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\AttachPermissionsToRoleRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class AttachPermissionsToRoleAction extends Action
{
    /**
     * @param Role $role
     * @param int|string|Permission|array|\Illuminate\Support\Collection $permissions
     *
     * @return Role
     */
    public function handle(Role $role, $permissions): Role
    {
        return $role->givePermissionTo($permissions);
    }

    /**
     * @param AttachPermissionsToRoleRequest $request
     * @param Role $role
     *
     * @return RoleResource
     */
    public function asController(AttachPermissionsToRoleRequest $request, Role $role): RoleResource
    {
        $permissions = Arr::wrap($request->permissions_ids);

        return new RoleResource(
            $this->handle($role, $permissions)
        );
    }
}
