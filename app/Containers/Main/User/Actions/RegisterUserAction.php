<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Events\UserRegisteredEvent;
use App\Containers\Main\User\Mails\UserRegisteredMail;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Notifications\UserRegisteredNotification;
use App\Containers\Main\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\Main\User\UI\API\Requests\RegisterUserRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class RegisterUserAction extends Action
{
    public function run(RegisterUserRequest $request): User
    {
        $user = app(CreateUserByCredentialsTask::class)->run(
            $request->email,
            $request->password,
            $request->name,
        );

        Mail::send(new UserRegisteredMail($user));
        Notification::send($user, new UserRegisteredNotification($user));
        app(Dispatcher::class)->dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}
