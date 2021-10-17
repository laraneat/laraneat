<?php

namespace App\Modules\User\Data\Seeders;

use App\Modules\Authorization\Actions\CreatePermissionAction;
use App\Modules\Authorization\DTO\CreatePermissionDTO;
use App\Ship\Abstracts\Seeders\Seeder;

class UserPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        $createPermissionAction = CreatePermissionAction::make();
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'view-users',
            displayName: 'View users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'create-users',
            displayName: 'Create users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'update-users',
            displayName: 'Update users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'delete-users',
            displayName: 'Delete users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'force-delete-users',
            displayName: 'Force delete users',
            group: 'users'
        ));
    }
}
