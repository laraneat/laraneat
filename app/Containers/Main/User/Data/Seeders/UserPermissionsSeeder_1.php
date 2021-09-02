<?php

namespace App\Containers\Main\User\Data\Seeders;

use App\Containers\Main\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Parents\Seeders\Seeder;

class UserPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        $createPermissionTask = app(CreatePermissionTask::class);
        $createPermissionTask->run(
            'view-users',
            'Просмотр пользователей',
            'users'
        );
        $createPermissionTask->run(
            'create-users',
            'Создание пользователей',
            'users'
        );
        $createPermissionTask->run(
            'update-users',
            'Изменение пользователей',
            'users'
        );
        $createPermissionTask->run(
            'delete-users',
            'Удаление пользователей',
            'users'
        );
        $createPermissionTask->run(
            'force-delete-users',
            'Принудительное удаление пользователей',
            'users'
        );
    }
}
