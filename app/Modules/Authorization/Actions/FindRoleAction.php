<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Actions\Action;

class FindRoleAction extends Action
{
    public function handle(int|string $roleNameOrId): Role
    {
        $query = is_numeric($roleNameOrId) ? ['id' => $roleNameOrId] : ['name' => $roleNameOrId];

        return Role::where($query)->first();
    }
}
