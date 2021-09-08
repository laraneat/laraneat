<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\ViewUserRequest;
use App\Ship\Abstracts\Actions\Action;

class ViewUserAction extends Action
{
    public function run(ViewUserRequest $request, User $user): User
    {
        return $user;
    }
}
