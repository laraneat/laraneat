<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserAction extends Action
{
    /**
     * @return User|null
     */
    public function handle(): ?User
    {
        return Auth::user();
    }

    /**
     * @param GetAuthenticatedUserRequest $request
     *
     * @return UserResource
     * @throws NotFoundException
     */
    public function asController(GetAuthenticatedUserRequest $request): UserResource
    {
        $user = $this->handle();

        if (!$user) {
            throw new NotFoundException();
        }

        return new UserResource($user);
    }
}
