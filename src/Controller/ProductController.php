<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CounterService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(
        private ProductService $productService,
        private CounterService $counterService,
    ) {}

    #[Route('/products/{id}', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        $product = $this->productService->findProductById($id);

        if ($product === []) {
            return new JsonResponse([
                'error' => 'Product not found',
            ], 404);
        }

        return new JsonResponse([
            'data' => $product,
        ]);
    }

    #[Route('/products/{id}/views', methods: ['GET'])]
    public function productViews(int $id): JsonResponse
    {
        return new JsonResponse([
            'views' => $this->counterService->getCount($id),
        ]);
    }
}
