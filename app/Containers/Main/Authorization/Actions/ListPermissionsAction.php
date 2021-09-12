<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\QueryWizards\PermissionsQueryWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ListPermissionsRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Pagination\AbstractPaginator;

class ListPermissionsAction extends Action
{
    /**
     * @param ListPermissionsRequest $request
     * 
     * @return AbstractPaginator
     */
    public function handle(ListPermissionsRequest $request): AbstractPaginator
    {
        return PermissionsQueryWizard::for(Permission::query())
            ->build()
            ->jsonPaginate();
    }
}
