<?php

namespace App\Services\Device\Commands;

use App\Dto\TransportDto;

class CreateDeviceDto extends TransportDto
{
    public function __construct(
        public string $userId,
        public string $fcmToken,
        public string $platform,
    )
    {
    }
}