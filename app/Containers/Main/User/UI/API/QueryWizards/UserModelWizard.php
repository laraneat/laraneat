<?php

namespace App\Containers\Main\User\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\EloquentModelWizard;

class UserModelWizard extends EloquentModelWizard
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
