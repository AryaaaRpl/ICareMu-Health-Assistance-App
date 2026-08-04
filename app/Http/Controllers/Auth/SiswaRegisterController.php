<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SiswaRegisterController extends Controller
{
    public function create(): View
    {
        $sekolahs = \App\Models\Sekolah::select('id', 'nama_sekolah')->orderBy('nama_sekolah')->get();

        return view('auth.register-siswa', compact('sekolahs'));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'sekolah_id'    => ['required', 'integer', 'exists:sekolahs,id'],
            'nisn'          => ['required', 'string', 'max:20', 'unique:siswa,nisn'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'nama_ortu'     => ['required', 'string', 'max:255'],
            'no_wa_ortu'    => ['required', 'string', 'max:20'],
        ]);

        try {
            $user = DB::transaction(function () use ($validated): User {
                $user = User::create([
                    'name'           => $validated['name'],
                    'email'          => $validated['email'],
                    'password'       => Hash::make($validated['password']),
                    'sekolah_id'     => $validated['sekolah_id'],
                    'role'           => 'siswa',
                    'payment_status' => 'unpaid',
                ]);

                Siswa::create([
                    'user_id'       => $user->id,
                    'sekolah_id'    => $validated['sekolah_id'],
                    'nama_lengkap'  => $validated['name'],
                    'nisn'          => $validated['nisn'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'nama_ortu'     => $validated['nama_ortu'],
                    'no_wa_ortu'    => $validated['no_wa_ortu'],
                ]);

                return $user;
            });
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'email' => __('Pendaftaran gagal. Silakan coba lagi.'),
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
