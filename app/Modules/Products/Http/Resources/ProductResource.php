<?php

declare(strict_types=1);

namespace App\Modules\Products\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (float) $this->price,
            'stock' => (int) $this->stock,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
