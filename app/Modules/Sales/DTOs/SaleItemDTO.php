<?php

declare(strict_types=1);

namespace App\Modules\Sales\DTOs;

class SaleItemDTO
{
    public function __construct(
        public readonly int $productId,
        public readonly int $quantity,
        public readonly float $discountPercent = 0.0
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            productId: (int) $data['product_id'],
            quantity: (int) $data['quantity'],
            discountPercent: isset($data['discount_percent']) ? (float) $data['discount_percent'] : 0.0
        );
    }
}
