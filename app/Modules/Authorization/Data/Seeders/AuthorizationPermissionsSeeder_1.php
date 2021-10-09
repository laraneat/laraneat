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
            displayName: 'Управление ролями',
            group: 'roles',
            description: 'Просмотр, создание, изменение и удаление любых ролей и прикрепление к ним любых прав доступа.'
        ));
        $createPermissionAction->handle(new CreatePermissionDTO(
            name: 'attach-roles',
            displayName: 'Назначение ролей',
            group: 'roles',
            description: 'Назначение ролей пользователям.',
        ));
    }
}
