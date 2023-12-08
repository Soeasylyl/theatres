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
     *  Handles the UserUpdateEvent by checking if the "blocked_until" attribute has been modified to null,
     *   and if so, sends an UnbanNotificationMail to the user's email address.
     *
     * @param UserUpdateEvent $event
     * @return void
     */
    public function handle(UserUpdateEvent $event): void
    {
        if ($event->blockedIsDirty && $event->user->blocked_until === null) {
            Mail::to($event->user->email)->send(new UnbanNotificationMail($event->user));
        }
    }

    /**
     * @param UserUpdateEvent $event
     * @param \Throwable $exception
     * @return void
     */
    public function failed(UserUpdateEvent $event, \Throwable $exception): void
    {
        Log::error('Failed to send unban notification email for User ID: ' . $event->user->id
            . 'Message:' . $exception->getMessage()
        );
    }
}
