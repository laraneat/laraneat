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
            displayName: 'Просмотр пользователей',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'create-users',
            displayName: 'Создание пользователей',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'update-users',
            displayName: 'Изменение пользователей',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'delete-users',
            displayName: 'Удаление пользователей',
            group: 'users'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'force-delete-users',
            displayName: 'Принудительное удаление пользователей',
            group: 'users'
        ));
    }
}
