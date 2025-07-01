<?php

namespace App\Collection;

use App\Entity\Vegetable;
use Doctrine\ORM\EntityManagerInterface;

class VegetableCollection extends AbstractCollection
{
  protected function getClass(): string
  {
    return Vegetable::class;
  }
}
