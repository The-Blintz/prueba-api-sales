<?php

declare(strict_types=1);

namespace App\Modules\Products\Actions;

use App\Models\Product;
use App\Modules\Products\DTOs\CreateProductDTO;

class CreateProductAction
{
    public function execute(CreateProductDTO $dto): Product
    {
        return Product::create([
            'name' => $dto->name,
            'price' => $dto->price,
            'stock' => $dto->stock,
        ]);
    }
}
