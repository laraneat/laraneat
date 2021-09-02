<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Tasks\CreateRoleTask;
use App\Ship\Parents\Seeders\Seeder;

class AuthorizationRolesSeeder_2 extends Seeder
{
    public function run(): void
    {
        // Default Roles ----------------------------------------------------------------
        $role = app(CreateRoleTask::class)->run('admin', 'Полный доступ ко всем возможностям системы', 'Администратор');
    }
}
