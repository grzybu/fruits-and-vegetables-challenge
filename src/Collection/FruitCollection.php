<?php

namespace App\Collection;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;

class FruitCollection extends AbstractCollection
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    protected function getClass(): string
    {
        return Fruit::class;
    }
}
