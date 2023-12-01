<?php

namespace App\Listeners;

use App\Events\UserUpdateEvent;
use App\Mail\UnbanNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserUnbannedListener implements ShouldQueue
{
    /**
     * Handles the UserUpdateEvent by checking if the "blocked_until" attribute has been modified to null,
     *  and if so, sends an UnbanNotificationMail to the user's email address.
     */
    public function handle(UserUpdateEvent $event): void
    {
        if ($event->blockedIsDirty && $event->user->blocked_until === null) {
            try {
                Mail::to($event->user->email)->send(new UnbanNotificationMail($event->user));
            } catch (\Exception $e) {
                Log::error('Failed to send unban notification email to ' . $event->user->email . ': ' . $e->getMessage());
            }
        }
    }
}
