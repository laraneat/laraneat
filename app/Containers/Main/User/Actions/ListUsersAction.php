<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Tasks\ListUsersTask;
use App\Containers\Main\User\UI\API\Requests\ListUsersRequest;
use App\Ship\Parents\Actions\Action;

class ListUsersAction extends Action
{
    public function run(ListUsersRequest $request)
    {
        return app(ListUsersTask::class)->run();
    }
}
