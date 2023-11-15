<?php

namespace App\Listeners;

use App\Events\UserUpdateEvent;
use App\Mail\BanNotificationMail;
use Illuminate\Support\Facades\Mail;

class UserBannedListener
{
    /**
     * Handles the UserUpdateEvent by checking if the "blocked_until" attribute has been modified and set to a non-null value.
     * If true, sends a BanNotificationMail to notify the user about the newly applied ban.
     */
    public function handle(UserUpdateEvent $event): void
    {
        if ($event->user->isDirty('blocked_until') && $event->user->blocked_until !== null) {
            Mail::to($event->user->email)->send(new BanNotificationMail($event->user));
        }
    }
}
