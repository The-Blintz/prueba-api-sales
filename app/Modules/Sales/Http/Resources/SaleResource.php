<?php

declare(strict_types=1);

namespace App\Modules\Sales\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => (float) $this->total,
            'total_discount' => (float) $this->total_discount,
            'created_at' => optional($this->created_at)->format('Y-m-d'),
            'details' => SaleDetailResource::collection($this->whenLoaded('details')),
        ];
    }
}
