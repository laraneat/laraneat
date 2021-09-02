<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tasks\DetachPermissionsFromRoleTask;
use App\Containers\Main\Authorization\Tasks\FindRoleTask;
use App\Containers\Main\Authorization\UI\API\Requests\DetachPermissionToRoleRequest;
use App\Ship\Parents\Actions\Action;

class DetachPermissionsFromRoleAction extends Action
{
    public function run(DetachPermissionToRoleRequest $request): Role
    {
        $role = app(FindRoleTask::class)->run($request->role_id);
        return app(DetachPermissionsFromRoleTask::class)->run($role, $request->permissions_ids);
    }
}
