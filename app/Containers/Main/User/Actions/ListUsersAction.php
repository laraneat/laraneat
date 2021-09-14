<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\QueryWizards\UsersQueryWizard;
use App\Containers\Main\User\UI\API\Requests\ListUsersRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListUsersAction extends Action
{
    /**
     * @param ListUsersRequest $request
     *
     * @return AbstractPaginator
     */
    public function handle(ListUsersRequest $request): AbstractPaginator
    {
        return UsersQueryWizard::for(User::query(), $request)
            ->build()
            ->jsonPaginate();
    }

    /**
     * @param ListUsersRequest $request
     * @return ResourceCollection
     */
    public function asController(ListUsersRequest $request): ResourceCollection
    {
        return UserResource::collection($this->handle($request));
    }
}
