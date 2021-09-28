<?php

namespace App\Modules\User\Mails;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserForgotPasswordMail extends Mail implements ShouldQueue
{
    use Queueable;

    protected User $recipient;

    protected string $token;

    protected string $resetUrl;

    public function __construct(User $recipient, string $token, string $resetUrl)
    {
        $this->recipient = $recipient;
        $this->token = $token;
        $this->resetUrl = $resetUrl;
    }

    public function build(): self
    {
        return $this->view('user::mails.user-forgot-password')
            ->to($this->recipient->email, $this->recipient->name)
            ->with([
                'token' => $this->token,
                'resetUrl' => $this->resetUrl,
                'email' => $this->recipient->email,
            ]);
    }
}
