<?php

namespace App\Services\Device;

use App\Dto\Resource\GenericResourceDto;
use App\Services\Device\Commands\CreateDeviceDto;
use App\Services\Device\Commands\Handler\CreateDeviceCommand;

class DeviceService
{
    /**
     * @param CreateDeviceDto $dto
     * @return GenericResourceDto
     */
    public function create(CreateDeviceDto $dto): GenericResourceDto
    {
        return CreateDeviceCommand::execute($dto);
    }
}