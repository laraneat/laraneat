<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\AttachPermissionsToRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
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
