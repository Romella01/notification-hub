<?php

namespace App\Services\Fcm;

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Models\{Device, Notification};

readonly class FcmService
{
    public function __construct(private Messaging $messaging)
    {
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function send(Device $device, Notification $n): array
    {
        $msg = CloudMessage::withTarget('token', $device->fcm_token)
            ->withNotification([
                'title' => $n->title,
                'body' => $n->body,
            ]);

        return $this->messaging->send($msg);
    }
}