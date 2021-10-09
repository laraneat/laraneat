<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\UI\API\QueryWizards\RolesQueryWizard;
use App\Modules\Authorization\UI\API\Requests\ListRolesRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListUserRolesAction extends Action
{
    public function handle(ListRolesRequest $request, User $user): AbstractPaginator
    {
        return RolesQueryWizard::for($user->roles(), $request)
            ->build()
            ->jsonPaginate();
    }

    public function asController(ListRolesRequest $request, User $user): ResourceCollection
    {
        return RoleResource::collection($this->handle($request, $user));
    }
}
