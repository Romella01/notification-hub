<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\CreateDeviceRequest;
use App\Http\Resources\Device\DeviceResource;
use App\Services\Device\Commands\CreateDeviceDto;
use App\Services\Device\DeviceService;

class DeviceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function crete(CreateDeviceRequest $request, DeviceService $service): DeviceResource
    {
        return new DeviceResource(
            $service->crete(
                new CreateDeviceDto(
                    $request->getUserId(),
                    $request->getFcmToken(),
                    $request->getPlatform(),
                )
            )->value
        );
    }
}
