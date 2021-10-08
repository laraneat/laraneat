<?php

namespace App\Modules\User\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentQueryWizard;
use Jackardios\QueryWizard\Handlers\Eloquent\Filters\AbstractEloquentFilter;
use Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude;
use Jackardios\QueryWizard\Handlers\Eloquent\Sorts\AbstractEloquentSort;

class UsersQueryWizard extends EloquentQueryWizard
{
    /**
     * @return array<string>
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
     * @return array<string|AbstractEloquentFilter>
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
     * @return array<string|AbstractEloquentInclude>
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles'
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
            'email',
            'created_at',
            'updated_at'
        ];
    }
}
