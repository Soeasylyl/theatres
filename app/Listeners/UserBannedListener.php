<?php

namespace App\Listeners;

use App\Events\UserUpdateEvent;
use App\Mail\BanNotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserBannedListener implements ShouldQueue
{
    /**
     * Handles the UserUpdateEvent by checking if the "blocked_until" attribute has been modified and set to a non-null value.
     *  If true, sends a BanNotificationMail to notify the user about the newly applied ban.
     *
     * @param UserUpdateEvent $event
     * @return void
     */
    public function handle(UserUpdateEvent $event): void
    {
        if ($event->blockedIsDirty && $event->user->blocked_until !== null) {
            Mail::to($event->user->email)->send(new BanNotificationMail($event->user));
        }
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception): void
    {
        Log::error($exception->getMessage());
    }
}
