<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Pagination\AbstractPaginator;

class ListRolesAction extends Action
{
    public function run(): AbstractPaginator
    {
        return RolesQueryWizard::for(Role::query())
            ->build()
            ->jsonPaginate();
    }
}
