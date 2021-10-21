<?php

namespace App\Modules\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\ModelQueryWizard;
use Jackardios\QueryWizard\Handlers\Model\Includes\AbstractModelInclude;

class PermissionQueryWizard extends ModelQueryWizard
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
            'group',
            'display_name',
            'description',
            'created_at',
            'updated_at',
            'roles.id',
            'roles.name',
            'roles.guard_name',
            'roles.display_name',
            'roles.description',
            'roles.created_at',
            'roles.updated_at',
        ];
    }

    /**
     * @return array<string|AbstractModelInclude>
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles',
            'rolesCount',
            'users',
            'usersCount',
        ];
    }
}
