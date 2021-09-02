<?php

namespace App\Containers\Main\User\UI\API\Controllers;

use App\Containers\Main\User\Actions\DeleteUserAction;
use App\Containers\Main\User\Actions\ViewUserAction;
use App\Containers\Main\User\Actions\ListUsersAction;
use App\Containers\Main\User\Actions\GetAuthenticatedUserAction;
use App\Containers\Main\User\Actions\RegisterUserAction;
use App\Containers\Main\User\Actions\UpdateUserAction;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\DeleteUserRequest;
use App\Containers\Main\User\UI\API\Requests\ViewUserRequest;
use App\Containers\Main\User\UI\API\Requests\ListUsersRequest;
use App\Containers\Main\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Containers\Main\User\UI\API\Requests\RegisterUserRequest;
use App\Containers\Main\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Controller extends ApiController
{
    public function registerUser(RegisterUserRequest $request): JsonResponse
    {
        $registeredUser = app(RegisterUserAction::class)->run($request);
        return (new UserResource($registeredUser))->created();
    }

    public function updateUser(UpdateUserRequest $request, User $user): UserResource
    {
        $updatedUser = app(UpdateUserAction::class)->run($request, $user);
        return new UserResource($updatedUser);
    }

    public function deleteUser(DeleteUserRequest $request, User $user): JsonResponse
    {
        app(DeleteUserAction::class)->run($request, $user);
        return $this->noContent();
    }

    public function listUsers(ListUsersRequest $request): ResourceCollection
    {
        $users = app(ListUsersAction::class)->run($request);
        return UserResource::collection($users);
    }

    public function viewUser(ViewUserRequest $request, User $user): UserResource
    {
        $user = app(ViewUserAction::class)->run($request, $user);
        return new UserResource($user);
    }

    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request): UserResource
    {
        $user = app(GetAuthenticatedUserAction::class)->run($request);
        return new UserResource($user);
    }
}
