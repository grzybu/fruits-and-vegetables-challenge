<?php

namespace App\Collection;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;

class FruitCollection extends AbstractCollection
{
    public function __construct(EntityManagerInterface $em, string $className = Fruit::class)
    {
        parent::__construct($em, $className);
    }
}