<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property array $resource
 */
class AuthorizationTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource['auth']['token'],
            'token_type' => 'Bearer',
            'expires_in' => AuthService::ttl(),
            'user' => UserResource::make($this->resource['user'])
        ];
    }
}
