<?php

namespace App\Containers\Main\User\Notifications;

use App\Containers\Main\User\Models\User;
use App\Ship\Abstracts\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray($notifiable): array
    {
        return [
            // ... do you own customization
        ];
    }
}
