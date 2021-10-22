<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Actions\Action;

class UpdatePermissionAction extends Action
{
    public function handle(Permission $permission, array $data): Permission
    {
        $permission->update($data);

        return $permission;
    }
}
