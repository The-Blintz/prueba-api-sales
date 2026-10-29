<?php

declare(strict_types=1);

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Sales\Actions\CreateSaleAction;
use App\Modules\Sales\Actions\DeleteSaleAction;
use App\Modules\Sales\Actions\GetSaleAction;
use App\Modules\Sales\Actions\GetSalesAction;
use App\Modules\Sales\DTOs\CreateSaleDTO;
use App\Modules\Sales\Http\Requests\StoreSaleRequest;
use App\Modules\Sales\Http\Resources\SaleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SaleController extends Controller
{
    public function __construct(
        private readonly GetSalesAction $getSalesAction,
        private readonly GetSaleAction $getSaleAction,
        private readonly CreateSaleAction $createSaleAction,
        private readonly DeleteSaleAction $deleteSaleAction
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return SaleResource::collection($this->getSalesAction->execute());
    }

    public function store(StoreSaleRequest $request): JsonResponse
    {
        $dto = CreateSaleDTO::fromRequest($request);
        $sale = $this->createSaleAction->execute($dto);

        return response()->json([
            'message' => 'Venta creada correctamente',
            'sale_id' => $sale->id,
            'total' => (float) $sale->total,
            'total_discount' => (float) $sale->total_discount,
        ], 201);
    }

    public function show(int $id): JsonResponse|SaleResource
    {
        $sale = $this->getSaleAction->execute($id);

        if (! $sale) {
            return response()->json(['message' => 'La venta no existe'], 404);
        }

        return new SaleResource($sale);
    }

    public function destroy(int $id): JsonResponse
    {
        $sale = $this->getSaleAction->execute($id);

        if (! $sale) {
            return response()->json(['message' => 'La venta no existe'], 404);
        }

        $this->deleteSaleAction->execute($sale);

        return response()->json(['message' => 'Venta eliminada correctamente']);
    }
}
