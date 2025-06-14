<?php

namespace App\Dto;

class TransportDto extends AbstractDto
{
    public function id(): int
    {
        return $this->id ?? 0;
    }
}
