<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductService $productService
    ) {}

    #[Route('/product/{id}', methods: ['GET'])]
    public function detail(string $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);

        if ($product === null) {
            return new JsonResponse([
                'error' => 'Product not found'
            ], 404);
        }

        return new JsonResponse([
            'data' => $product
        ]);
    }

    #[Route('/counter/product/{id}', methods: ['GET'])]
    public function productCount(int $id): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->productService->getRequestCounter($id)
        ]);
    }
}
