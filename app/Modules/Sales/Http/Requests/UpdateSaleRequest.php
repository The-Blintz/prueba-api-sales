<?php

declare(strict_types=1);

namespace App\Modules\Sales\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Opcional según si requieres actualizar ventas en tu API de ventas
        return [
            'user_id' => ['sometimes', 'integer'],
        ];
    }
}
