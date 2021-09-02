<?php

namespace App\Containers\Main\Authorization\UI\CLI\Commands;

use App\Containers\Main\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Tasks\FindRoleTask;
use App\Ship\Parents\Commands\ConsoleCommand;

class GiveAllPermissionsToRoleCommand extends ConsoleCommand
{
    protected $signature = 'laraneat:permissions:toRole {role}';

    protected $description = 'Give all system Permissions to a specific Role.';

    /**
     * @throws RoleNotFoundException
     */
    public function handle(): void
    {
        $roleName = $this->argument('role');

        $allPermissions = Permission::all();

        $role = app(FindRoleTask::class)->run($roleName);

        if (!$role) {
            throw new RoleNotFoundException("Role $roleName is not found!");
        }

        $role->syncPermissions($allPermissionsNames = $allPermissions->pluck('name')->toArray());

        $this->info('Gave the Role (' . $roleName . ') the following Permissions: ' . implode(' - ',
                $allPermissionsNames) . '.');
    }
}
