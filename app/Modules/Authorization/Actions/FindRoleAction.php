<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Ship\Abstracts\Actions\Action;

class FindRoleAction extends Action
{
    /**
     * @param string|int $roleNameOrId
     */
    public function handle($roleNameOrId): Role
    {
        $query = is_numeric($roleNameOrId) ? ['id' => $roleNameOrId] : ['name' => $roleNameOrId];

        return Role::where($query)->first();
    }
}
