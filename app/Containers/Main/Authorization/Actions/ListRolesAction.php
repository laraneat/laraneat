<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ListRolesRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
        return RolesQueryWizard::for(Role::query(), $request)
            ->build()
            ->jsonPaginate();
    }

    /**
     * @param ListRolesRequest $request
     * @return ResourceCollection
     */
    public function asController(ListRolesRequest $request): ResourceCollection
    {
        return RoleResource::collection($this->handle($request));
    }
}
