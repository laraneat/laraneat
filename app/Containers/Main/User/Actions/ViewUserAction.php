<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\QueryWizards\UserQueryWizard;
use App\Containers\Main\User\UI\API\Requests\ViewUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ViewUserAction extends Action
{
    /**
     * @param ViewUserRequest $request
     * @param User $user
     *
     * @return Model
     */
    public function handle(ViewUserRequest $request, User $user): Model
    {
        return UserQueryWizard::for($user, $request)->build();
    }

    /**
     * @param ViewUserRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function asController(ViewUserRequest $request, User $user): UserResource
    {
        return new UserResource($this->handle($request, $user));
    }
}
