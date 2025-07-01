<?php

namespace App\Collection;

use App\Entity\Vegetable;
use Doctrine\ORM\EntityManagerInterface;

class VegetableCollection extends AbstractCollection
{
    public function __construct(EntityManagerInterface $em, string $className = Vegetable::class)
    {
        parent::__construct($em, $className);
    }

}