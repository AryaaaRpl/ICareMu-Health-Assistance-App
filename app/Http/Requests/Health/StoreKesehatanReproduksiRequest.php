<?php

declare(strict_types=1);

namespace App\Http\Requests\Health;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreKesehatanReproduksiRequest
 *
 * Validates request data for storing reproductive health tracking.
 *
 * @package App\Http\Requests\Health
 */
class StoreKesehatanReproduksiRequest extends FormRequest
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
            'siswa_id' => ['required', 'exists:siswa,id'],
            'tanggal_haid' => ['required', 'date'],
        ];
    }
}
