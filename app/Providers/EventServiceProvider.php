<?php

namespace App\Providers;

use App\Events\ClearStoreEvent;
use App\Events\UserUpdateEvent;
use App\Listeners\ClearStoreEventListener;
use App\Listeners\UserBannedListener;
use App\Listeners\UserUnbannedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserUpdateEvent::class => [
            UserBannedListener::class,
            UserUnbannedListener::class,
        ],
        ClearStoreEvent::class => [
            ClearStoreEventListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
