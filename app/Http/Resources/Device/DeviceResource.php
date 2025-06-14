<?php

namespace App\Http\Resources\Device;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read  Device $resource
 */
class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'platform' => $this->resource->platform,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
