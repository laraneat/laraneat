<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\QueryWizards\PermissionsQueryWizard;
use App\Ship\Abstracts\Actions\Action;

class ListPermissionsAction extends Action
{
    public function run(): \Illuminate\Pagination\AbstractPaginator
    {
        return PermissionsQueryWizard::for(Permission::query())
            ->build()
            ->jsonPaginate();
    }
}
