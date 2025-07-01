<?php

namespace App\Service;

use App\Collection\CollectionInterface;
use App\Entity\ItemFactory;
use Doctrine\ORM\EntityManagerInterface;

class StorageService
{
    public function __construct(
        /** @var CollectionInterface[] $collections */
        private iterable $collections,
        public string $request = '' {
        get {
        return $this->request;
        }
        set {
        $this->request = $value;
        }
        }
    ) {
        $collections = $collections instanceof \Traversable ? iterator_to_array($collections) : $collections;
        $this->collections = $collections;
    }

    public function loadData(bool $clearOldData = true): void
    {
        if (empty($this->request)) {
            throw new \InvalidArgumentException('Request path cannot be empty');
        }

        if (!json_validate($this->request)) {
            throw new \RuntimeException("Invalid JSON data in request");
        }

        $data = json_decode($this->request, true);

        if ($clearOldData) {
            $this->clearCollections();
        }

        $this->processData($data);
    }

    private function clearCollections(): void
    {
        foreach ($this->collections as $collection) {
            if ($collection instanceof CollectionInterface) {
                $collection->clear();
            }
        }
    }

    /**
     * @param  array<int, array<string, mixed>> $data
     */
    private function processData(array $data): void
    {
        /**
         *
         */
        foreach ($data as $item) {
            $item = ItemFactory::createFromArray($item);

            if ($item === null) {
                continue; // Skip items that don't match any type
            }

            /** @var CollectionInterface $collection */
            foreach ($this->collections as $collection) {
                if ($collection->supports($item)) {
                    $collection->add($item);
                    break; // Stop after adding to the first matching collection
                }
            }
        }
    }
}
