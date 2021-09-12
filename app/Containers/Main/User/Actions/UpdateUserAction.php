<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction extends Action
{
    /**
     * @param User $user
     * @param array $userData
     *
     * @return User
     * @throws UpdateResourceFailedException
     */
    public function handle(User $user, array $userData): User
    {
        if (empty($userData)) {
            throw new UpdateResourceFailedException();
        }

        if (array_key_exists('password', $userData)) {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user->update($userData);

        return $user;
    }


    public function asController(UpdateUserRequest $request, User $user): UserResource
    {
        $sanitizedData = $request->sanitizeInput([
            'password',
            'name',
        ]);

        $user = $this->handle($user, $sanitizedData);

        return new UserResource($user);
    }
}
