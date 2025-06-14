<?php

namespace App\Cqrs\Query;

use App\Cqrs\QueryHandlerInterface;
use App\Dto\DtoInterface;

abstract class AbstractQueryHandler implements QueryHandlerInterface
{
    /**
     * @param DtoInterface $dto
     * @return DtoInterface
     */
    public static function execute(DtoInterface $dto): DtoInterface
    {
        /** @var AbstractQueryHandler $command */
        $command = (app(static::class));

        return $command->handle($dto);
    }
}