<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthService
 *
 * Handles authentication tasks, including student registration transactions and credentials verification.
 *
 * @package App\Services
 */
class AuthService
{
    /**
     * Registers a new student and their associated user account within a database transaction.
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function registerSiswa(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            // Create user login credentials.
            /** @var User $user */
            $user = User::create([
                'sekolah_id' => $data['sekolah_id'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'siswa',
                'payment_status' => 'unpaid',
            ]);

            // Create student profile record linked to the user account.
            Siswa::create([
                'user_id' => $user->id,
                'sekolah_id' => $data['sekolah_id'],
                'nama_lengkap' => $data['nama_lengkap'],
                'nisn' => $data['nisn'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'nama_ortu' => $data['nama_ortu'],
                'no_wa_ortu' => $data['no_wa_ortu'],
                'golongan_darah' => $data['golongan_darah'],
            ]);

            return $user;
        });
    }

    /**
     * Authenticates a user by email or student NISN and issues a Sanctum API token.
     *
     * @param array{credential: string, password: string} $credentials
     * @return array{user: User, token: string}
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        $user = null;
        $credential = $credentials['credential'];

        // If numeric, attempt authentication via student NISN.
        if (is_numeric($credential)) {
            $siswa = Siswa::where('nisn', $credential)->first();
            if ($siswa !== null) {
                $user = $siswa->user;
            }
        } else {
            // Otherwise, attempt authentication via standard email.
            $user = User::where('email', $credential)->first();
        }

        // Validate user presence and password.
        if ($user === null || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'credential' => [trans('auth.failed')],
            ]);
        }

        // Generate Sanctum access token.
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
