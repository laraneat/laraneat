<?php

namespace App\Containers\Main\Authorization\UI\API\QueryWizards;

use App\Ship\Parents\QueryWizards\EloquentQueryWizard;

class PermissionsQueryWizard extends EloquentQueryWizard
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
            'updated_at'
        ];
    }

    /**
     * @return \Jackardios\QueryWizard\Handlers\Eloquent\Filters\AbstractEloquentFilter[]|string[]
     */
    protected function allowedFilters(): array
    {
        return [
            'id',
            'name',
            'guard_name',
            'group',
            'display_name'
        ];
    }

    /**
     * @return \Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude[]|string[]
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles',
            'users'
        ];
    }

    /**
     * @return \Jackardios\QueryWizard\Handlers\Eloquent\Sorts\AbstractEloquentSort[]|string[]
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
            'updated_at'
        ];
    }
}
