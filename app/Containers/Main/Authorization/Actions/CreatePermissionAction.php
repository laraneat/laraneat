<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Abstracts\Requests\Request;

class CreatePermissionAction extends Action
{
    public function run(Request $request): Permission
    {
        return app(CreatePermissionTask::class)->run(
            $request->name,
            $request->description,
            $request->display_name
        );
    }
}
