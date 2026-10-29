<?php

declare(strict_types=1);

namespace App\Modules\Products\Actions;

use App\Models\Product;

class GetProductAction
{
    public function execute(int $id): ?Product
    {
        return Product::find($id);
    }
}
