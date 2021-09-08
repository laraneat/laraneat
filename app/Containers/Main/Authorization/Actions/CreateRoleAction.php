<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\Tasks\CreateRoleTask;
use App\Containers\Main\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Ship\Abstracts\Actions\Action;

class CreateRoleAction extends Action
{
    public function run(CreateRoleRequest $request): Role
    {
        return app(CreateRoleTask::class)->run($request->name, $request->description, $request->display_name);
    }
}
