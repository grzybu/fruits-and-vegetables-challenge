<?php

namespace App\Service;

use App\Entity\ItemFactory;
use Doctrine\ORM\EntityManagerInterface;

class StorageService
{


    public function __construct(
        private iterable $collections,
    )
    {
        $collections = $collections instanceof \Traversable ? iterator_to_array($collections) : $collections;
        $this->collections = $collections;

    }
    public function getCollections()
    {
        return array_map(function ($collection) {
            return get_class($collection);
        }, (array)$this->collections);

    }

    public function processJson(string $jsonPath): void
    {
        $data = json_decode(file_get_contents($jsonPath), true);

        var_dump($data);
        foreach ($data as $item) {

            $item = ItemFactory::createFromArray($item);

            if ($item === null) {
                continue; // Skip items that don't match any type
            }

            foreach ($this->collections as $collection) {
                if ($collection->supports($item)) {
                    $collection->addItem($item);
                    break; // Stop after adding to the first matching collection
                }
            }
        }
        $this->em->flush();
    }

    public function getAll()
    {


    }

}
