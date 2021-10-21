<?php

namespace App\Modules\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentQueryWizard;
use Jackardios\QueryWizard\Handlers\Eloquent\Filters\AbstractEloquentFilter;
use Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude;
use Jackardios\QueryWizard\Handlers\Eloquent\Sorts\AbstractEloquentSort;

class PermissionsQueryWizard extends EloquentQueryWizard
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
     * @return array<string|AbstractEloquentFilter>
     */
    protected function allowedFilters(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'group',
            'display_name',
        ];
    }

    /**
     * @return array<string|AbstractEloquentInclude>
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

    /**
     * @return array<string|AbstractEloquentSort>
     */
    protected function allowedSorts(): array
    {
        return [
            'id',
            'name',
            'group',
            'guard_name',
            'display_name',
            'created_at',
            'updated_at',
        ];
    }
}
