<?php

namespace App\Containers\Main\Authorization\Tasks;

use App\Containers\Main\Authorization\Models\Role;
use App\Ship\Abstracts\Tasks\Task;

class DetachPermissionsFromRoleTask extends Task
{
    public function run(Role $role, $singleOrMultiplePermissionIds): Role
    {
        if (!is_array($singleOrMultiplePermissionIds)) {
            $singleOrMultiplePermissionIds = [$singleOrMultiplePermissionIds];
        }

        array_map(static function ($permissionId) use ($role) {
            $permission = app(FindPermissionTask::class)->run($permissionId);
            $role->revokePermissionTo($permission);
        }, $singleOrMultiplePermissionIds);

        return $role;
    }
}
