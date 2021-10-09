<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\UI\API\QueryWizards\PermissionsQueryWizard;
use App\Modules\Authorization\UI\API\Requests\ListPermissionsRequest;
use App\Modules\Authorization\UI\API\Resources\PermissionResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListPermissionsAction extends Action
{
    public function handle(ListPermissionsRequest $request): AbstractPaginator
    {
        return PermissionsQueryWizard::for(Permission::query(), $request)
            ->build()
            ->jsonPaginate();
    }

    public function asController(ListPermissionsRequest $request): ResourceCollection
    {
        return PermissionResource::collection($this->handle($request));
    }
}
