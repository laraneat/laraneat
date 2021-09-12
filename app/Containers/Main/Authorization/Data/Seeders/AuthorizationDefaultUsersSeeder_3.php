<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Actions\FindRoleAction;
use App\Containers\Main\User\Actions\CreateUserAction;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    public function run(): void
    {
        $admin = CreateUserAction::run(
            email: 'admin@admin.com',
            password: 'admin',
            name: 'Супер администратор'
        );
        $admin->assignRole(FindRoleAction::make()->handle('admin'));
        $admin->email_verified_at = now();
        $admin->save();
    }
}
