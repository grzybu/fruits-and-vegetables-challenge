<?php

namespace App\Dto;

use App\Enum\Unit;

class ItemDto
{
    public function __construct(
        public string $name,
        public int $quantity,
        public Unit $unit = Unit::Gram,
    ) {
    }
}
