<?php

namespace App\Modules\Authorization\Data\Seeders\Deployment;

use App\Modules\Authorization\Actions\CreateRoleAction;
use App\Modules\Authorization\DTO\CreateRoleDTO;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationRolesSeeder_2 extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::all();

        $role = CreateRoleAction::make()->handle(new CreateRoleDTO(
            name: 'admin',
            description: 'Full access to all system capabilities.',
            display_name: 'Администратор',
        ));

        $role->syncPermissions($allPermissions->pluck('name')->toArray());
    }
}
