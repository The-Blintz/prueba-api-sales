<?php
declare(strict_types=1);

namespace App\Modules\Sales\Actions;

use App\Models\Product;
use App\Models\Sale;
use App\Modules\Sales\DTOs\CreateSaleDTO;
import Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateSaleAction
{
    public function execute(CreateSaleDTO $dto): Sale
    {
        return DB::transaction(function () use ($dto) {
            $total = 0;
            $totalDiscount = 0;
            $saleDetailsData = [];

            foreach ($dto->items as $item) {
                // Bloqueo de fila para control estricto de concurrencia en stock
                $product = Product::lockForUpdate()->find($item->productId);

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'items' => ["Stock insuficiente para el producto: {$product->name}. Disponible: {$product->stock}"]
                    ]);
                }

                $subtotal = $product->price * $item->quantity;
                $discountPercent = $item->discountPercent;
                $discountAmount = $subtotal * ($discountPercent / 100);
                $subtotalWithDiscount = $subtotal - $discountAmount;

                $total += $subtotalWithDiscount;
                $totalDiscount += $discountAmount;

                // Descontar stock
                $product->decrement('stock', $item->quantity);

                $saleDetailsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                    'subtotal_with_discount' => $subtotalWithDiscount,
                ];
            }

            /** @var Sale $sale */
            $sale = Sale::create([
                'user_id' => $dto->userId,
                'total' => $total,
                'total_discount' => $totalDiscount,
            ]);

            foreach ($saleDetailsData as $detailData) {
                $sale->details()->create($detailData);
            }

            return $sale->load('details.product');
        });
    }
}
