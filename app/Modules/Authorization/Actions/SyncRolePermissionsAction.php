<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\SyncRolePermissionsRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SyncRolePermissionsAction extends Action
{
    public function handle(Role $role, int|string|array|Collection|Permission $permissions): Role
    {
        return $role->syncPermissions($permissions);
    }

    public function asController(SyncRolePermissionsRequest $request, Role $role): RoleResource
    {
        $permissions = Arr::wrap($request->permission_ids);

        return new RoleResource($this->handle($role, $permissions));
    }
}
