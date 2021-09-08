<?php

namespace App\Containers\Main\Authorization\Data\Seeders;

use App\Containers\Main\Authorization\Tasks\FindRoleTask;
use App\Containers\Main\User\Tasks\CreateUserByCredentialsTask;
use App\Ship\Abstracts\Seeders\Seeder;

class AuthorizationDefaultUsersSeeder_3 extends Seeder
{
    public function run(): void
    {
        // Default Users (with their roles) ---------------------------------------------
        $admin = app(CreateUserByCredentialsTask::class)->run('admin@admin.com', 'admin', 'Супер администратор');
        $admin->assignRole(app(FindRoleTask::class)->run('admin'));
        $admin->email_verified_at = now();
        $admin->save();
    }
}
