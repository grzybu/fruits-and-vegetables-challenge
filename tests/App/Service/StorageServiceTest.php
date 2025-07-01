<?php

namespace App\Tests\App\Service;

use App\Collection\FruitCollection;
use App\Collection\VegetableCollection;
use App\Entity\Fruit;
use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    public function testReceivingRequest(): void
    {
        $request = file_get_contents('request.json');

        $storageService = new StorageService([], $request);
        $this->assertNotEmpty($storageService->request);
    }

    public function testReceivingRequestWithEmptyData(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Request path cannot be empty');

        $storageService = new StorageService([]);
        $storageService->loadData();
    }

    public function testReceivingRequestWithInvalidJson(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid JSON data in request');

        $invalidJson = '{"name": "Apple", "quantity": 1, "unit": "kg"'; // Missing closing brace
        $storageService = new StorageService([], $invalidJson);
        $storageService->loadData();
    }

    public function testReceivingRequestWithValidJson(): void
    {
        $validJson = '[{"id":1,"name":"Carrot","type":"vegetable","quantity":10922,"unit":"g"},{"id":5,"name":"Beans","type":"vegetable","quantity":65000,"unit":"g"},{"id":2,"name":"Apples","type":"fruit","quantity":20,"unit":"kg"}]';
        $fruitCollection = $this->createPartialMock(FruitCollection::class, ['add', 'clear']);
        $vegetableCollection = $this->createPartialMock(VegetableCollection::class, ['add', 'clear']);

        $fruitCollection->expects($this->exactly(1))
            ->method('add');

        $vegetableCollection->expects($this->exactly(2))
            ->method('add');



        $storageService = new StorageService(
            [
                $fruitCollection
            ], $validJson

        );

        $this->assertNotEmpty($storageService->request);
        $this->assertIsString($storageService->request);

        // Assuming loadData processes the request and does not throw an exception
        $storageService->loadData();


    }
}
