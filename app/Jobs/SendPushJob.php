<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\Notification;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Throwable;
use DateTimeInterface;

class SendPushJob implements ShouldQueue
{
    use Queueable;

    public array $backoff = [30, 60, 120];

    public function __construct(
        public readonly int $notificationId,
        public readonly int $deviceId,
    )
    {
    }

    /**
     * @throws Throwable
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function handle(FcmService $fcm): void
    {
        /** @var Notification $notification */
        $notification = Notification::query()->findOrFail($this->notificationId);

        /** @var Device $device */
        $device = Device::query()->findOrFail($this->deviceId);

        $pivot = $notification->devices()
            ->where('devices.id', $device->id)
            ->firstOrFail()
            ->pivot;

        try {
            $response = $fcm->send($device, $notification);

            $pivot->update([
                'status' => 'sent',
                'response_payload' => $response,
            ]);
        } catch (Throwable $e) {
            $pivot->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addMinutes(5);
    }
}
