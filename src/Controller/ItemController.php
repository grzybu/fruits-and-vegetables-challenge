<?php

namespace App\Controller;

use App\Collection\CollectionInterface;
use App\Enum\Unit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class ItemController
{
    public function __construct(
        private CollectionInterface $collection,
        private string $message
    ) {
    }

    public function __invoke(
        #[MapQueryParameter] ?int $id = null,
        #[MapQueryParameter] ?string $name = null,
        #[MapQueryParameter] ?int $limit = null,
        #[MapQueryParameter] ?int $offset = null,
        #[MapQueryParameter] Unit $unit = Unit::Gram
    ): Response {
        $criteria = [];
        if ($id !== null) {
            $criteria['id'] = $id;
        }
        if ($name !== null) {
            $criteria['name'] = $name;
        }

        $items = $this->collection->search($criteria, $unit, $limit, $offset);

        return new JsonResponse([
            'data' => $items,
            'meta' => [
                'count' => count($items),
            ],
            'message' => $this->message
        ], Response::HTTP_OK);
    }
}
