<?php

namespace App\Tests\Dto;

use App\Enum\Unit;
use PHPUnit\Framework\TestCase;
use App\Dto\ItemDto;

class ItemDtoTest extends TestCase
{
    public function testItemDtoCreation(): void
    {
        $name = 'name';
        $quantity = 1000;
        $unit = Unit::Gram;

        $itemDto = new ItemDto($name, $quantity, $unit);
        $this->assertEquals($name, $itemDto->name);
        $this->assertEquals($quantity, $itemDto->quantity);
        $this->assertEquals($unit, $itemDto->unit);
    }
}
