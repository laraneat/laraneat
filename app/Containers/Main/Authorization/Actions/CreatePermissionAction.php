<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;

class CreatePermissionAction extends Action
{
    /**
     * @param string $name
     * @param string|null $displayName
     * @param string|null $group
     * @param string|null $description
     *
     * @return Permission
     * @throws CreateResourceFailedException
     */
    public function handle(
        string $name,
        ?string $displayName = null,
        ?string $group = null,
        ?string $description = null
    ): Permission
    {
        try {
            $permission = Permission::create([
                'name' => $name,
                'description' => $description,
                'display_name' => $displayName,
                'group' => $group,
                'guard_name' => 'web',
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $permission;
    }
}
