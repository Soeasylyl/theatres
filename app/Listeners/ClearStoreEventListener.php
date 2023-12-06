<?php

namespace App\Listeners;

use App\Events\ClearStoreEvent;
use Illuminate\Support\Facades\Storage;

class ClearStoreEventListener
{
    /**
     * Handle the event.
     */
    public function handle(ClearStoreEvent $event): void
    {
        if  ($event->model->path && Storage::disk('public')->exists($event->model->path)) {
            Storage::disk('public')->delete($event->model->path);
        }
    }
}
