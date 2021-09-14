<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\SyncRolePermissionsRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;

class SyncRolePermissionsAction extends Action
{
    /**
     * @param Role $role
     * @param int|string|Permission|array|\Illuminate\Support\Collection $permissions
     *
     * @return Role
     */
    public function handle(Role $role, $permissions): Role
    {
        return $role->syncPermissions($permissions);
    }

    /**
     * @param SyncRolePermissionsRequest $request
     *
     * @return RoleResource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function asController(SyncRolePermissionsRequest $request): RoleResource
    {
        $role = Role::findOrFail($request->role_id);
        $permissions = Arr::wrap($request->permissions_ids);

        return new RoleResource($this->handle($role, $permissions));
    }
}
