<?php

namespace App\Modules\Authorization\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentQueryWizard;
use Jackardios\QueryWizard\Handlers\Eloquent\Filters\AbstractEloquentFilter;
use Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude;
use Jackardios\QueryWizard\Handlers\Eloquent\Sorts\AbstractEloquentSort;

class RolesQueryWizard extends EloquentQueryWizard
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
     * @return array<string|AbstractEloquentFilter>
     */
    protected function allowedFilters(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'display_name'
        ];
    }

    /**
     * @return array<string|AbstractEloquentInclude>
     */
    protected function allowedIncludes(): array
    {
        return [
            'permissions',
            'users'
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
            'guard_name',
            'display_name',
            'created_at',
            'updated_at'
        ];
    }
}
