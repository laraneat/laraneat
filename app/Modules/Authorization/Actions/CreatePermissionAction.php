<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\DTO\CreatePermissionDTO;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Actions\Action;

class CreatePermissionAction extends Action
{
    public function handle(CreatePermissionDTO $dto): Permission
    {
        return Permission::create([
            'name' => $dto->name,
            'description' => $dto->description,
            'display_name' => $dto->displayName,
            'group' => $dto->group,
            'guard_name' => $dto->guardName,
        ]);
    }
}
