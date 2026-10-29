<?php

declare(strict_types=1);

namespace App\Modules\Products\DTOs;

use App\Modules\Products\Http\Requests\StoreProductRequest;

class CreateProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly int $stock
    ) {}

    public static function fromRequest(StoreProductRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            price: (float) $request->validated('price'),
            stock: (int) $request->validated('stock'),
        );
    }
}
