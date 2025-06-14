<?php

namespace App\Console\Commands;

use App\Jobs\DispatchNotificationJob;
use App\Models\Notification;
use Illuminate\Console\Command;

class DispatchDueNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-due-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch Due Notifications';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Notification::query()
            ->where('dispatched', false)
            ->where('send_at', '<=', now())
            ->each(fn($n) => DispatchNotificationJob::dispatch($n));

        return self::SUCCESS;
    }
}
