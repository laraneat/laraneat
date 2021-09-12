<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ListRolesRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Pagination\AbstractPaginator;

class ListRolesAction extends Action
{
    /**
     * @param ListRolesRequest $request
     * 
     * @return AbstractPaginator
     */
    public function handle(ListRolesRequest $request): AbstractPaginator
    {
        return RolesQueryWizard::for(Role::query())
            ->build()
            ->jsonPaginate();
    }
}
