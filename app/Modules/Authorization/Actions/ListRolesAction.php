<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Modules\Authorization\UI\API\Requests\ListRolesRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListRolesAction extends Action
{
    public function handle(ListRolesRequest $request): AbstractPaginator
    {
        return RolesQueryWizard::for(Role::query(), $request)
            ->build()
            ->jsonPaginate();
    }

    /**
     * @param ListRolesRequest $request
     *
     * @return ResourceCollection
     */
    public function asController(ListRolesRequest $request): ResourceCollection
    {
        return RoleResource::collection($this->handle($request));
    }
}
