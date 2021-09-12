<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Actions\CreatePermissionAction;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationPermissionsSeeder_1 extends Seeder
{
    public function run(): void
    {
        $createPermissionAction = CreatePermissionAction::make();
        $createPermissionAction->handle(
            name: 'manage-roles',
            displayName: 'Управление ролями',
            group: 'roles',
            description: 'Просмотр, создание, изменение и удаление любых ролей и прикрепление к ним любых прав доступа.',
        );
        $createPermissionAction->handle(
            name: 'attach-roles',
            displayName: 'Назначение ролей',
            group: 'roles',
            description: 'Назначение ролей пользователям.',
        );
    }
}
