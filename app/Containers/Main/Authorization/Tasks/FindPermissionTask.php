<?php

namespace App\Containers\Main\Authorization\Tasks;

use App\Containers\Main\Authorization\Models\Permission;
use App\Ship\Parents\Tasks\Task;

class FindPermissionTask extends Task
{
    public function run($permissionNameOrId): Permission
    {
        $query = is_numeric($permissionNameOrId) ? ['id' => $permissionNameOrId] : ['name' => $permissionNameOrId];

        return Permission::where($query)->first();
    }
}
