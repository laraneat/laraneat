<?php

namespace App\Modules\User\UI\API\QueryWizards;

use App\Ship\Abstracts\QueryWizards\ModelQueryWizard;
use Jackardios\QueryWizard\Handlers\Model\Includes\AbstractModelInclude;

class UserQueryWizard extends ModelQueryWizard
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
     * @return array<string|AbstractModelInclude>
     */
    protected function allowedIncludes(): array
    {
        return [
            'roles'
        ];
    }
}
