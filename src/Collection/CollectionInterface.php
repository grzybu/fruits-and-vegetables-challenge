<?php

namespace App\Collection;

use App\Dto\ItemDto;
use App\Entity\Item;
use App\Enum\Unit;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.item_collection')]
interface CollectionInterface
{
    public function add(Item $item): void;

    public function remove(Item $item): void;

    /**
     * @return array<int, Item>
     */
    public function list(): array;

    /**
     * Search for items based on criteria.
     * @param array<string, mixed> $criteria
     * @return array<int, ItemDto>
     */
    public function search(
        array $criteria = [],
        Unit $unit = Unit::Gram,
        ?int $limit = null,
        ?int $offset = null
    ): array;

    public function supports(Item $item): bool;

    public function clear(): void;
}
