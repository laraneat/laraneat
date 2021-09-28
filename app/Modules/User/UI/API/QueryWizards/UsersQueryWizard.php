<?php

namespace App\Modules\User\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentQueryWizard;

class UsersQueryWizard extends EloquentQueryWizard
{
    /**
     * @return string[]
     */
    protected function allowedFields(): array
    {
        return [
            'id',
            'name',
            'email',
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
            'email',
        ];
    }

    /**
     * @return \Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude[]|string[]
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles'
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
            'email',
            'created_at',
            'updated_at'
        ];
    }
}
