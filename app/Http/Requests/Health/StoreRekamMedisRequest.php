<?php

declare(strict_types=1);

namespace App\Http\Requests\Health;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRekamMedisRequest
 *
 * Validates the request data for creating a medical record (rekam medis).
 *
 * @package App\Http\Requests\Health
 */
class StoreRekamMedisRequest extends FormRequest
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
            'tanggal_periksa' => ['required', 'date'],
            'tinggi_badan' => ['required', 'numeric', 'min:1'],
            'berat_badan' => ['required', 'numeric', 'min:1'],
            'catatan_medis' => ['nullable', 'string'],
        ];
    }
}
