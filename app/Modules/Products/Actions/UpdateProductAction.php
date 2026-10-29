<?php

declare(strict_types=1);

namespace App\Modules\Products\Actions;

use App\Models\Product;
use App\Modules\Products\DTOs\UpdateProductDTO;

class UpdateProductAction
{
    public function execute(Product $product, UpdateProductDTO $dto): Product
    {
        $product->update(array_filter([
            'name' => $dto->name,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ], fn ($value) => ! is_null($value)));

        return $product;
    }
}
