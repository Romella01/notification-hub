<?php

namespace App\Services\Auth\Commands;

use App\Dto\TransportDto;

final class LoginDto extends TransportDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ){
    }
}
