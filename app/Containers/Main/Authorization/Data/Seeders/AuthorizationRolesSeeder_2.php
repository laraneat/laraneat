<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Actions\CreateRoleAction;
use App\Containers\Main\Authorization\Models\Permission;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationRolesSeeder_2 extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::all();

        $role = CreateRoleAction::make()->handle(
            name: 'admin',
            description: 'Полный доступ ко всем возможностям системы.',
            displayName: 'Администратор',
        );
        
        $role->syncPermissions($allPermissions->pluck('name')->toArray());
    }
}
