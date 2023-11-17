<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public bool $blockedIsDirty;

    /**
     *
     * Create a new event instance.
     */
    public function __construct(
        public readonly User $user,
    )
    {
        $this->blockedIsDirty = $user->isDirty('blocked_until');
    }
}
