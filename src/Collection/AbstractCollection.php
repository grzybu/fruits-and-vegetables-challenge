<?php

namespace App\Collection;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractCollection implements CollectionInterface
{

    private EntityManagerInterface $em;

    protected string $className;

    public function __construct(EntityManagerInterface $em, string $className)
    {
        $this->em = $em;
        $this->className = $className;

    }

    public function add(Item $item): void
    {
        if (!$this->supports($item)) {
            throw new \InvalidArgumentException('Item type not supported');
        }

        $this->em->persist($item);
        $this->em->flush();
    }

    public function remove(Item $item): void
    {
        if (!$this->supports($item)) {
            throw new \InvalidArgumentException('Item type not supported');
        }

        $this->em->remove($item);
        $this->em->flush();
    }

    public function getItems(): array
    {
        return $this->em->getRepository($this->className)->findAll();
    }

    public function search(): array
    {
        return $this->em->getRepository($this->className)->findBy([]);
    }

    public function supports(Item $item): bool
    {
        return $item instanceof $this->className;
    }


}