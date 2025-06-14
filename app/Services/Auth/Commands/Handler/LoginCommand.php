<?php

namespace App\Services\Auth\Commands\Handler;

use App\Cqrs\Command\AbstractCommandHandler;
use App\Dto\DtoInterface;
use App\Dto\Resource\GenericResourceDto;
use App\Models\User;
use App\Services\Auth\Commands\LoginDto;
use Illuminate\Auth\AuthenticationException;
use InvalidArgumentException;

final class LoginCommand extends AbstractCommandHandler
{
    /**
     * @throws AuthenticationException
     */
    public function handle(DtoInterface $dto): DtoInterface
    {
        if (!($dto instanceof LoginDto))
            throw new InvalidArgumentException();

        $token = auth('api')->attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ]);

        if (!$token)
            throw new AuthenticationException('Invalid Credentials');

        /** @var User $user */
        $user = auth('api')->user();

        return new GenericResourceDto([
            'auth' => [
                'token' => $token
            ],
            'user' => $user
        ]);
    }
}
