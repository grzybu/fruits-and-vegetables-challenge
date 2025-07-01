<?php

namespace App\Entity;

use App\Entity\Fruit;
use App\Entity\Vegetable;

class ItemFactory
{
    /**
     * Map of item types to their corresponding entity classes.
     *
     * @var array<string, class-string<object>>
     */
    protected static array $typeMap = [
        'fruit' => Fruit::class,
        'vegetable' => Vegetable::class,
        // Add more types here as needed
    ];

    /**
     * @param array<string, mixed> $item
     */
    public static function createFromArray(array $item): ?Item
    {
        $type = $item['type'] ?? null;
        if (!isset(self::$typeMap[$type])) {
            return null;
        }

        $entityClass = self::$typeMap[$type];
        $quantity = $item['unit'] === 'kg' ? $item['quantity'] * 1000 : $item['quantity'];

        return new $entityClass($item['name'], $quantity);
    }
}
