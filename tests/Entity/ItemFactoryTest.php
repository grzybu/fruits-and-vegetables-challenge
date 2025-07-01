<?php

namespace App\Tests\Entity;

use App\Entity\Fruit;
use App\Entity\ItemFactory;
use App\Entity\Vegetable;
use PHPUnit\Framework\TestCase;

class ItemFactoryTest extends TestCase
{
    public function testCreateFromArrayWithValidFruit(): void
    {
        $data = [
            'type' => 'fruit',
            'name' => 'Apple',
            'quantity' => 2,
            'unit' => 'kg',
        ];

        $item = ItemFactory::createFromArray($data);

        $this->assertInstanceOf(Fruit::class, $item);
        $this->assertEquals('Apple', $item->getName());
        $this->assertEquals(2000, $item->getQuantity()); // Converted to grams
    }

    public function testCreateFromArrayWithValidVegetable(): void
    {
        $data = [
            'type' => 'vegetable',
            'name' => 'Carrot',
            'quantity' => 500,
            'unit' => 'g',
        ];

        $item = ItemFactory::createFromArray($data);

        $this->assertInstanceOf(Vegetable::class, $item);
        $this->assertEquals('Carrot', $item->getName());
        $this->assertEquals(500, $item->getQuantity());
    }

    public function testCreateFromArrayWithInvalidType(): void
    {
        $data = [
            'type' => 'unknown',
            'name' => 'Mystery Item',
            'quantity' => 1,
            'unit' => 'kg',
        ];

        $item = ItemFactory::createFromArray($data);

        $this->assertNull($item);
    }

    public function testCreateFromArrayWithMissingType(): void
    {
        $data = [
            'name' => 'Nameless Item',
            'quantity' => 1,
            'unit' => 'kg',
        ];

        $item = ItemFactory::createFromArray($data);

        $this->assertNull($item);
    }

    public function testCreateFromArrayWithInvalidUnit(): void
    {
        $data = [
            'type' => 'fruit',
            'name' => 'Banana',
            'quantity' => 1,
            'unit' => 'unknown_unit',
        ];

        $item = ItemFactory::createFromArray($data);

        $this->assertInstanceOf(Fruit::class, $item);
        $this->assertEquals(1, $item->getQuantity()); // No conversion applied
    }
}
