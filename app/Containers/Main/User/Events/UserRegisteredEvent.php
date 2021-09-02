<?php

namespace App\Containers\Main\User\Events;

use App\Containers\Main\User\Models\User;
use App\Ship\Parents\Events\Event;
use Illuminate\Broadcasting\Channel;
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
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
