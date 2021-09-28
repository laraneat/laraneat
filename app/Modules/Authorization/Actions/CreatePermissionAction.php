<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\Actions\Action;

class CreatePermissionAction extends Action
{
    /**
     * @param string $name
     * @param string|null $displayName
     * @param string|null $group
     * @param string|null $description
     *
     * @return Permission
     */
    public function handle(
        string $name,
        ?string $displayName = null,
        ?string $group = null,
        ?string $description = null
    ): Permission
    {
        return Permission::create([
            'name' => $name,
            'description' => $description,
            'display_name' => $displayName,
            'group' => $group,
            'guard_name' => 'web',
        ]);
    }
}
