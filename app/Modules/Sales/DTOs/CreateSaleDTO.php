<?php

declare(strict_types=1);

namespace App\Modules\Sales\DTOs;

use App\Modules\Sales\Http\Requests\StoreSaleRequest;

class CreateSaleDTO
{
    /**
     * @param  SaleItemDTO[]  $items
     */
    public function __construct(
        public readonly int $userId,
        public readonly array $items
    ) {}

    public static function fromRequest(StoreSaleRequest $request): self
    {
        $items = array_map(
            fn (array $item) => SaleItemDTO::fromArray($item),
            $request->validated('items')
        );

        return new self(
            userId: (int) $request->validated('user_id', 1),
            items: $items
        );
    }
}
