<?php

namespace App\Modules\User\Events;

use App\Modules\User\Models\User;
use App\Ship\Abstracts\Events\Event;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UserRegisteredEvent extends Event implements ShouldQueue
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the Event. (Single Listener Implementation)
     */
    public function handle(): void
    {
        Log::info('New User registration. ID = ' . $this->user->getKey() . ' | Email = ' . $this->user->email . '.');
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
