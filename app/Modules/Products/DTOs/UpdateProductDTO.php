<?php

declare(strict_types=1);

namespace App\Modules\Products\DTOs;

use App\Modules\Products\Http\Requests\UpdateProductRequest;

class UpdateProductDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?float $price,
        public readonly ?int $stock
    ) {}

    public static function fromRequest(UpdateProductRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            price: $request->has('price') ? (float) $request->validated('price') : null,
            stock: $request->has('stock') ? (int) $request->validated('stock') : null,
        );
    }
}
