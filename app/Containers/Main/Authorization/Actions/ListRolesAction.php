<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Ship\Abstracts\Actions\Action;

class ListRolesAction extends Action
{
    public function run(): \Illuminate\Pagination\AbstractPaginator
    {
        return RolesQueryWizard::for(Role::query())
            ->build()
            ->jsonPaginate();
    }
}
