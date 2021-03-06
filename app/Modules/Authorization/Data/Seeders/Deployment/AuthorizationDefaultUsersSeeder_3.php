<?php

namespace App\Modules\Authorization\Data\Seeders\Deployment;

use App\Modules\Authorization\Actions\FindRoleAction;
use App\Modules\User\Actions\CreateUserAction;
use App\Modules\User\DTO\CreateUserDTO;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    public function run(): void
    {
        $admin = CreateUserAction::make()->handle(new CreateUserDTO(
            name: 'Администратор',
            email: config('authorization-module.admin.email', 'admin@example.com'),
            password: config('authorization-module.admin.password', 'changeme'),
        ));
        $admin->assignRole(FindRoleAction::make()->handle('admin'));
        $admin->email_verified_at = now();
        $admin->save();
    }
}
