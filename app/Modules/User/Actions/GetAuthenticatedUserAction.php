<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Modules\User\UI\API\Resources\UserResource;
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
