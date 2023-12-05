<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveBan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-ban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::where('blocked_until', '<=', now())
            ->chunk(50, function ($users) {
                foreach ($users as $user) {
                    $user->update(['blocked_until' => null]);
                }
            });
    }
}
