<?php

declare(strict_types=1);

namespace App\Http\Requests\Screening;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreJadwalRequest
 *
 * Validates request data for scheduling a screening event.
 *
 * @package App\Http\Requests\Screening
 */
class StoreJadwalRequest extends FormRequest
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
            'jenis_skrining' => ['required', 'string', 'max:255'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(['scheduled', 'ongoing', 'completed', 'cancelled'])],
        ];
    }
}
