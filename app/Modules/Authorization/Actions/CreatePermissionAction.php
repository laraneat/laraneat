<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\DTO\CreatePermissionDTO;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Actions\Action;

class CreatePermissionAction extends Action
{
    public function handle(CreatePermissionDTO $permissionDTO): Permission
    {
        return Permission::create([
            'name' => $permissionDTO->name,
            'description' => $permissionDTO->description,
            'display_name' => $permissionDTO->displayName,
            'group' => $permissionDTO->group,
            'guard_name' => $permissionDTO->guard_name,
        ]);
    }
}
