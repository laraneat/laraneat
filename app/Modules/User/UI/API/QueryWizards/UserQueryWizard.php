<?php

namespace App\Modules\User\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\ModelQueryWizard;

class UserQueryWizard extends ModelQueryWizard
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
     * @return \Jackardios\QueryWizard\Handlers\Eloquent\Includes\AbstractEloquentInclude[]|string[]
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles'
        ];
    }
}