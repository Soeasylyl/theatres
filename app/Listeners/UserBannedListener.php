<?php

namespace App\Listeners;

use App\Events\UserBanned;
use App\Mail\BanNotificationMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class UserBannedListener
{
    protected $user;
    /**
     * Create a new job instance.
     */

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     */
    public function handle(UserBanned $event): void
    {
        Mail::to($event->user->email)->send(new BanNotificationMail());
    }
}
