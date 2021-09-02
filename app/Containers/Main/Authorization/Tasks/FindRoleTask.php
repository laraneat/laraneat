<?php

namespace App\Containers\Main\Authorization\Tasks;

use App\Containers\Main\Authorization\Models\Role;
use App\Ship\Parents\Tasks\Task;

class FindRoleTask extends Task
{
    public function run($roleNameOrId): Role
    {
        $query = is_numeric($roleNameOrId) ? ['id' => $roleNameOrId] : ['name' => $roleNameOrId];

        return Role::where($query)->first();
    }
}
