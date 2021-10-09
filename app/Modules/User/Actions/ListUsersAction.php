<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\QueryWizards\UsersQueryWizard;
use App\Modules\User\UI\API\Requests\ListUsersRequest;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListUsersAction extends Action
{
    public function handle(ListUsersRequest $request): AbstractPaginator
    {
        return UsersQueryWizard::for(User::query(), $request)
            ->build()
            ->jsonPaginate();
    }

    public function asController(ListUsersRequest $request): ResourceCollection
    {
        return UserResource::collection($this->handle($request));
    }
}
