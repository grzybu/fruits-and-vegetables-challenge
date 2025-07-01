<?php

namespace App\Entity;

use App\Entity\Fruit;
use App\Entity\Vegetable;

class ItemFactory
{
    protected static array $typeMap = [
        'fruit' => Fruit::class,
        'vegetable' => Vegetable::class,
        // Add more types here as needed
    ];

    public static function createFromArray(array $item): ?object
    {
        $type = $item['type'] ?? null;
        if (!isset($typeMap[$type])) {
            return null;
        }

        $entityClass = $this->typeMap[$type];
        $quantity = $item['unit'] === 'kg' ? $item['quantity'] * 1000 : $item['quantity'];

        return new $entityClass($item['name'], $quantity);
    }
}