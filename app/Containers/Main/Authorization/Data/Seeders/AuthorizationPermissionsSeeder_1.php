<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        // Default Permissions ----------------------------------------------------------
        $createPermissionTask = app(CreatePermissionTask::class);
        $createPermissionTask->run(
            'manage-roles',
            'Управление ролями',
            'roles',
            'Просмотр, создание, изменение и удаление любых ролей и прикрепление к ним любых прав доступа.',
        );
        $createPermissionTask->run(
            'assign-roles',
            'Назначение ролей',
            'roles',
            'Назначение ролей пользователям',
        );
    }
}
