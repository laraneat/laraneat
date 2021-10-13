<?php

namespace App\Modules\Authorization\UI\CLI\Commands;

use App\Modules\Authorization\Actions\FindRoleAction;
use App\Modules\Authorization\Exceptions\RoleNotFoundException;
use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Console\Command;

class GiveAllPermissionsToRoleCommand extends Command
{
    protected $signature = 'laraneat:permissions:to-role {role}';

    protected $description = 'Give all system Permissions to a specific Role.';

    /**
     * @throws RoleNotFoundException
     */
    public function handle(): int
    {
        $roleNameOrId = $this->argument('role');
        $allPermissions = Permission::all();

        $role = FindRoleAction::make()->handle($roleNameOrId);

        if (!$role) {
            throw new RoleNotFoundException("Role $roleNameOrId is not found!");
        }

        $role->syncPermissions($allPermissionsNames = $allPermissions->pluck('name')->toArray());

        $this->info('Gave the Role (' . $role->name . ') the following Permissions: ' . implode(' - ',
                $allPermissionsNames) . '.');

        return self::SUCCESS;
    }
}
