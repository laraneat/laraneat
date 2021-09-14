<?php

namespace App\Containers\Main\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentModelWizard;

class PermissionModelWizard extends EloquentModelWizard
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
     * @return \Jackardios\QueryWizard\Handlers\Model\Includes\AbstractModelInclude[]|string[]
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles',
            'users'
        ];
    }
}
