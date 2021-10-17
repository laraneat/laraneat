<?php

namespace App\Modules\Authorization\Data\Seeders;

use App\Modules\Authorization\Actions\CreatePermissionAction;
use App\Modules\Authorization\DTO\CreatePermissionDTO;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        $createPermissionAction = CreatePermissionAction::make();
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'manage-roles',
            displayName: 'Managing roles',
            group: 'roles',
            description: 'View, create, change and delete any roles and assign any permissions to them.'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'attach-roles',
            displayName: 'Assigning roles to users',
            group: 'roles',
        ));
    }
}
