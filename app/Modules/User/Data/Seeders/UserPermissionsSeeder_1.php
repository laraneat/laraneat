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
            display_name: 'View users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'create-users',
            display_name: 'Create users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'update-users',
            display_name: 'Update users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'delete-users',
            display_name: 'Delete users',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'force-delete-users',
            display_name: 'Force delete users',
            group: 'users'
        ));
    }
}
