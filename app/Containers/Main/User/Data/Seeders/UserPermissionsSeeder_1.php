<?php

namespace App\Containers\Main\User\Data\Seeders;

use App\Containers\Main\Authorization\Actions\CreatePermissionAction;
use App\Ship\Abstracts\Seeders\Seeder;

class UserPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        $createPermissionAction = CreatePermissionAction::make();
        $createPermissionAction->handle(
            name: 'view-users',
            displayName: 'Просмотр пользователей',
            group: 'users'
        );
        $createPermissionAction->handle(
            name: 'create-users',
            displayName: 'Создание пользователей',
            group: 'users'
        );
        $createPermissionAction->handle(
            name: 'update-users',
            displayName: 'Изменение пользователей',
            group: 'users'
        );
        $createPermissionAction->handle(
            name: 'delete-users',
            displayName: 'Удаление пользователей',
            group: 'users'
        );
        $createPermissionAction->handle(
            name: 'force-delete-users',
            displayName: 'Принудительное удаление пользователей',
            group: 'users'
        );
    }
}
