<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CounterService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller pro detail produktů a počet zobrazení.
 */
final class ProductController extends AbstractController
{
    /**
     * @param ProductService $productService Service pro práci s produkty
     * @param CounterService $counterService Service pro práci s počítadlem zobrazení
     */
    public function __construct(
        private ProductService $productService,
        private CounterService $counterService,
    ) {}

    /**
     * Vrátí detail produktu podle zadaného id.
     *
     * @param int $id id produktu
     * @return JsonResponse JSON produktu
     */
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

    /**
     * Vrátí počet zobrazení produktu podle ID.
     *
     * @param int $id ID produktu
     * @return JsonResponse JSON s počtem zobrazení produktu
     */
    #[Route('/products/{id}/views', methods: ['GET'])]
    public function productViews(int $id): JsonResponse
    {
        return new JsonResponse([
            'views' => $this->counterService->getCount($id),
        ]);
    }
}
