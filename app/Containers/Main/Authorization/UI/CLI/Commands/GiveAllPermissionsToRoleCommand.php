<?php

namespace App\Containers\Main\Authorization\UI\CLI\Commands;

use App\Containers\Main\Authorization\Actions\FindRoleAction;
use App\Containers\Main\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\Main\Authorization\Models\Permission;
use App\Ship\Abstracts\Console\Command;

class GiveAllPermissionsToRoleCommand extends Command
{
    protected $signature = 'laraneat:permissions:toRole {role}';

    protected $description = 'Give all system Permissions to a specific Role.';

    /**
     * @throws RoleNotFoundException
     */
    public function handle(): void
    {
        $roleNameOrId = $this->argument('role');
        $allPermissions = Permission::all();

        $role = FindRoleAction::run($roleNameOrId);
        
        if (!$role) {
            throw new RoleNotFoundException("Role $roleNameOrId is not found!");
        }

        $role->syncPermissions($allPermissionsNames = $allPermissions->pluck('name')->toArray());

        $this->info('Gave the Role (' . $role->name . ') the following Permissions: ' . implode(' - ',
                $allPermissionsNames) . '.');
    }
}
