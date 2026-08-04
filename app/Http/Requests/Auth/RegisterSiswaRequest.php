<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class RegisterSiswaRequest
 *
 * Validates the tenant-aware student registration payload.
 *
 * @package App\Http\Requests\Auth
 */
class RegisterSiswaRequest extends FormRequest
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
            'sekolah_id' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nisn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('siswa')->where(function ($query) {
                    return $query->where('sekolah_id', $this->input('sekolah_id'));
                }),
            ],
            'tanggal_lahir' => ['required', 'date'],
            'nama_ortu' => ['required', 'string', 'max:255'],
            'no_wa_ortu' => ['required', 'string', 'max:20'],
            'golongan_darah' => ['required', 'string', 'max:5'],
        ];
    }
}
