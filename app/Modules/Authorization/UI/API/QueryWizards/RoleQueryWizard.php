<?php

namespace App\Modules\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\ModelQueryWizard;
use Jackardios\QueryWizard\Handlers\Model\Includes\AbstractModelInclude;

class RoleQueryWizard extends ModelQueryWizard
{
    /**
     * @return array<string>
     */
    protected function allowedFields(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'display_name',
            'description',
            'created_at',
            'updated_at',
            'permissions.id',
            'permissions.name',
            'permissions.guard_name',
            'permissions.group',
            'permissions.display_name',
            'permissions.description',
            'permissions.created_at',
            'permissions.updated_at',
        ];
    }

    /**
     * @return array<string|AbstractModelInclude>
     */
    protected function allowedIncludes(): array
    {
        return [
            'permissions',
            'permissionsCount',
            'users',
            'usersCount',
        ];
    }
}
