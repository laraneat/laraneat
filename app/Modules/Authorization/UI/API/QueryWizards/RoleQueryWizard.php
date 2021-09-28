<?php

namespace App\Modules\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\ModelQueryWizard;

class RoleQueryWizard extends ModelQueryWizard
{
    /**
     * @return string[]
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
     * @return \Jackardios\QueryWizard\Handlers\Model\Includes\AbstractModelInclude[]|string[]
     */
    protected function allowedIncludes(): array
    {
        return [
            'permissions',
            'users'
        ];
    }
}
