<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\QueryWizards\UsersQueryWizard;
use App\Containers\Main\User\UI\API\Requests\ListUsersRequest;
use App\Ship\Abstracts\Actions\Action;

class ListUsersAction extends Action
{
    public function handle(ListUsersRequest $request)
    {
        return UsersQueryWizard::for(User::query())
            ->build()
            ->jsonPaginate();
    }
}
