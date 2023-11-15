<?php

namespace App\Listeners;

use App\Events\UserUpdateEvent;
use App\Mail\UnbanNotificationMail;
use Illuminate\Support\Facades\Mail;

class UserUnbannedListener
{
    /**
     * Handles the UserUpdateEvent by checking if the "blocked_until" attribute has been modified to null,
     *  and if so, sends an UnbanNotificationMail to the user's email address.
     */
    public function handle(UserUpdateEvent $event): void
    {
        if ($event->user->isDirty('blocked_until') && $event->user->blocked_until === null) {
                 Mail::to($event->user->email)->send(new UnbanNotificationMail($event->user));
            }
    }
}
