<?php

namespace App\Modules\User\Actions;

use App\Modules\User\DTO\CreateUserDTO;
use App\Modules\User\Events\UserRegisteredEvent;
use App\Modules\User\Mails\UserRegisteredMail;
use App\Modules\User\Models\User;
use App\Modules\User\Notifications\UserRegisteredNotification;
use App\Modules\User\UI\API\Requests\CreateUserRequest;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CreateUserAction extends Action
{
    public function handle(CreateUserDTO $userDTO): User
    {
        return User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => Hash::make($userDTO->password),
        ]);
    }

    public function asController(CreateUserRequest $request): JsonResponse
    {
        $user = $this->handle($request->toDTO());

        Mail::send(new UserRegisteredMail($user));
        Notification::send($user, new UserRegisteredNotification($user));

        dispatch(new UserRegisteredEvent($user));

        return (new UserResource($user))->created();
    }
}
