<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use App\Models\Device;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Notification $notification)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $devices = Device::query()->pluck('id');

        $this->notification
            ->devices()
            ->syncWithoutDetaching(
                $devices->mapWithKeys(fn($id) => [$id => ['status' => 'queued']])->all()
            );

        foreach ($devices as $deviceId) {
            SendPushJob::dispatch($this->notification->id, $deviceId)
                ->onQueue(QueueEnum::push->value)
                ->delay($this->notification->send_at);
        }

        $this->notification->update(['dispatched' => true]);
    }
}
