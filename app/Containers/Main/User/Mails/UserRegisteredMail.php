<?php

namespace App\Containers\Main\User\Mails;

use App\Containers\Main\User\Models\User;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredMail extends Mail implements ShouldQueue
{
    use Queueable;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): self
    {
        return $this->view('Main@user::user-registered')
            ->to($this->user->email, $this->user->name)
            ->with([
                'name' => $this->user->name,
            ]);
    }
}
