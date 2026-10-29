<?php

declare(strict_types=1);

namespace App\Modules\Sales\Actions;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DeleteSaleAction
{
    public function execute(Sale $sale): bool
    {
        return DB::transaction(function () use ($sale) {
            foreach ($sale->details as $detail) {
                $product = Product::lockForUpdate()->find($detail->product_id);
                if ($product) {
                    $product->increment('stock', $detail->quantity);
                }
            }

            $sale->details()->delete();

            return $sale->delete();
        });
    }
}
