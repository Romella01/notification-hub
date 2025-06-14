<?php

namespace App\Services\Auth;

use App\Dto\Resource\GenericResourceDto;
use App\Services\Auth\Commands\LoginDto;
use App\Services\Auth\Commands\Handler\LoginCommand;
use Illuminate\Support\Facades\Config;

final class AuthService
{
    /**
     * @param LoginDto $dto
     * @return GenericResourceDto<array>
     */
    public function login(LoginDto $dto): GenericResourceDto
    {
        return LoginCommand::execute($dto);
    }

    /*** @return int */
    public static function ttl(): int
    {
        return Config::get('jwt.ttl') * 60;
    }
}
