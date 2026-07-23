<?php

declare(strict_types=1);

namespace App\Http\Requests\Screening;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StorePesertaSkriningRequest
 *
 * Validates request data for registering a participant's screening result.
 *
 * @package App\Http\Requests\Screening
 */
class StorePesertaSkriningRequest extends FormRequest
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
            'jadwal_id' => ['required', 'exists:jadwal_skrining,id'],
            'siswa_id' => ['required', 'exists:siswa,id'],
            'status_kehadiran' => ['required', 'string', 'max:50'],
            'catatan_hasil' => ['nullable', 'string'],
        ];
    }
}
