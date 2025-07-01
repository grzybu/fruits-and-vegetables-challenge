<?php

namespace App\Collection;

use App\Dto\ItemDto;
use App\Entity\Item;
use App\Enum\Unit;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractCollection implements CollectionInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
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

    /**
     * @return array<int, ItemDto>
     */
    public function search(
        array $criteria = [],
        Unit $unit = Unit::Gram,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $allowed = ['id', 'name'];
        $filter = array_intersect_key($criteria, array_flip($allowed));

        $qb = $this->em->getRepository($this->getClass())->createQueryBuilder('i');

        foreach ($filter as $field => $value) {
            $qb->andWhere("i.$field = :$field")->setParameter($field, $value);
        }

        if ($limit !== null) {
            $qb->setMaxResults((int)$limit);
        }
        if ($offset !== null) {
            $qb->setFirstResult((int)$offset);
        }

        /** @var Item[] $results */
        $results = $qb->getQuery()->getResult();

        // Convert quantities
        return array_map(function ($item) use ($unit) {
            $quantity = $item->getQuantity();
            if ($unit === Unit::Kilogram) {
                $quantity = $quantity / 1000;
            }
            return new ItemDto(
                name: $item->getName(),
                quantity : $quantity,
                unit : $unit,
            );
        }, $results);
    }

    public function supports(Item $item): bool {
        $class = $this->getClass();
        return $item instanceof $class;
    }

    abstract protected function getClass(): string;


    public function list(): array
    {
        return $this->em->getRepository($this->getClass())->findAll();
    }

    public function clear(): void
    {
        $this->em->createQuery("DELETE FROM {$this->getClass()}")->execute();
    }
}
