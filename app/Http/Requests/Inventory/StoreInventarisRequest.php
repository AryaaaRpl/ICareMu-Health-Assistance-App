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

    protected function prepareForValidation(): void
    {
        $user = auth()->user();
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;

        // Menyuntikkan nilai sekolah_id ke dalam request data
        $this->merge([
            'sekolah_id' => $sekolahId,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;
        return [
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'tanggal_kedaluwarsa' => ['required', 'date'],
        ];
    }
}
