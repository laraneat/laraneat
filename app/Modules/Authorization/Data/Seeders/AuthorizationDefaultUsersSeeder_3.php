<?php

namespace App\Modules\Authorization\Data\Seeders;

use App\Modules\Authorization\Actions\FindRoleAction;
use App\Modules\User\Actions\CreateUserAction;
use App\Modules\User\DTO\CreateUserDTO;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    public function run(): void
    {
        $admin = CreateUserAction::make()->handle(new CreateUserDTO(
            email: 'admin@admin.com',
            password: 'admin',
            name: 'Супер администратор'
        ));
        $admin->assignRole(FindRoleAction::make()->handle('admin'));
        $admin->email_verified_at = now();
        $admin->save();
    }
}
