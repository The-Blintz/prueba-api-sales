<?php

declare(strict_types=1);

namespace App\Modules\Products\Actions;

use App\Models\Product;

class DeleteProductAction
{
    public function execute(Product $product): bool
    {
        return $product->delete();
    }
}
