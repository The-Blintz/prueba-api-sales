<?php

declare(strict_types=1);

namespace App\Modules\Sales\Actions;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class GetSalesAction
{
    public function execute(): Collection
    {
        return Sale::with(['details.product'])->latest()->get();
    }
}
