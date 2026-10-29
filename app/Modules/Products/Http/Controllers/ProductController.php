<?php

declare(strict_types=1);

namespace App\Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Actions\CreateProductAction;
use App\Modules\Products\Actions\DeleteProductAction;
use App\Modules\Products\Actions\GetProductAction;
use App\Modules\Products\Actions\GetProductsAction;
use App\Modules\Products\Actions\UpdateProductAction;
use App\Modules\Products\DTOs\CreateProductDTO;
use App\Modules\Products\DTOs\UpdateProductDTO;
use App\Modules\Products\Http\Requests\StoreProductRequest;
use App\Modules\Products\Http\Requests\UpdateProductRequest;
use App\Modules\Products\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private readonly GetProductsAction $getProductsAction,
        private readonly GetProductAction $getProductAction,
        private readonly CreateProductAction $createProductAction,
        private readonly UpdateProductAction $updateProductAction,
        private readonly DeleteProductAction $deleteProductAction
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->getProductsAction->execute());
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $dto = CreateProductDTO::fromRequest($request);
        $product = $this->createProductAction->execute($dto);

        return response()->json([
            'message' => 'Producto creado correctamente',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function show(int $id): JsonResponse|ProductResource
    {
        $product = $this->getProductAction->execute($id);

        if (! $product) {
            return response()->json(['message' => 'El producto no existe'], 404);
        }

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->getProductAction->execute($id);

        if (! $product) {
            return response()->json(['message' => 'El producto no existe'], 404);
        }

        $dto = UpdateProductDTO::fromRequest($request);
        $updatedProduct = $this->updateProductAction->execute($product, $dto);

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'data' => new ProductResource($updatedProduct),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $product = $this->getProductAction->execute($id);

        if (! $product) {
            return response()->json(['message' => 'El producto no existe'], 404);
        }

        $this->deleteProductAction->execute($product);

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
