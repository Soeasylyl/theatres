<?php

namespace App\Jobs;

use App\Mail\BlockNotification;
use App\Models\User;
use App\Services\UserService;
use GuzzleHttp\Promise\Create;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBlockedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private  readonly User $user)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(User $user): void
    {
        //
        Mail::to($user->email)->send(new BlockNotification());
    }
}
