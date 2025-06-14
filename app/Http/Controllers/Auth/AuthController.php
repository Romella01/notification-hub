<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthorizationTokenResource;
use App\Services\Auth\AuthService;
use App\Services\Auth\Commands\LoginDto;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    public function login(LoginRequest $request): AuthorizationTokenResource
    {
        $result = $this->authService->login(
            new LoginDto(
                $request->getEmail(),
                $request->getPassword()
            )
        )->value;

        return AuthorizationTokenResource::make($result);
    }
}
