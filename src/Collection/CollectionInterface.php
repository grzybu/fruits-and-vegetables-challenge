<?php

namespace App\Collection;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.item_collection')]
interface CollectionInterface
{
    public function add(Item $item): void;
    public function remove(Item $item): void;
    public function getItems(): array;

    public function search(): array;

    public function supports(Item $item): bool;

}