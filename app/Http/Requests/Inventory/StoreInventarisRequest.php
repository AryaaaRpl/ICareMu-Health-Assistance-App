<?php

declare(strict_types=1);

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreInventarisRequest
 *
 * Validates request data for storing UKS inventory items.
 *
 * @package App\Http\Requests\Inventory
 */
class StoreInventarisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'tanggal_kedaluwarsa' => ['required', 'date'],
        ];
    }
}
