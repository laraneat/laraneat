<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\QueryWizards\PermissionsQueryWizard;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Pagination\AbstractPaginator;

class ListPermissionsAction extends Action
{
    public function run(): AbstractPaginator
    {
        return PermissionsQueryWizard::for(Permission::query())
            ->build()
            ->jsonPaginate();
    }
}
