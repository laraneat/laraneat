<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\ViewUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;

class ViewUserAction extends Action
{
    /**
     * @param ViewUserRequest $request
     * 
     * @param User $user
     * @return UserResource
     */
    public function handle(ViewUserRequest $request, User $user): UserResource
    {
        return new UserResource($user);
    }
}
