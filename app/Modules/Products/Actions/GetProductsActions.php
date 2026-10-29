<?php

declare(strict_types=1);

namespace App\Modules\Products\Actions;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class GetProductsAction
{
    public function execute(): Collection
    {
        return Product::select('id', 'name', 'price', 'stock', 'created_at')->get();
    }
}
