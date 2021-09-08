<?php

namespace App\Containers\Main\Authorization\Tasks;

use App\Containers\Main\Authorization\Models\Role;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Abstracts\Tasks\Task;
use Exception;

class CreateRoleTask extends Task
{
    public function run(string $name, string $description = null, string $displayName = null): Role
    {
        app()['cache']->forget('spatie.permission.cache');

        try {
            $role = Role::create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => 'web',
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $role;
    }
}
