<?php

namespace App\Services\Device\Commands\Handler;

use App\Cqrs\Command\AbstractCommandHandler;
use App\Dto\DtoInterface;
use App\Dto\Resource\GenericResourceDto;
use App\Models\Device;
use App\Services\Device\Commands\CreateDeviceDto;
use InvalidArgumentException;

class CreateDeviceCommand extends AbstractCommandHandler
{
    public function handle(DtoInterface $dto): GenericResourceDto
    {
        if (!($dto instanceof CreateDeviceDto))
            throw new InvalidArgumentException(__('Invalid DTO'));

        $device = Device::query()
            ->updateOrCreate(
                ['user_id' => $dto->userId, 'fcm_token' => $dto->fcmToken],
                ['platform' => $dto->platform, 'last_seen_at' => now()]
            );

        return new GenericResourceDto($device);
    }
}