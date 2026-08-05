<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $sekolahs = \App\Models\Sekolah::select('id', 'nama_sekolah')->orderBy('nama_sekolah')->get();

        return view('auth.register', compact('sekolahs'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Step 1: Standard account credentials
            'name' => ['nullable', 'string', 'max:255'],
            'nama_lengkap' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'jenis_kelamin' => ['required', 'string', 'in:Laki-laki,Perempuan,L,P'],

            // Step 2 & 3: Additional student & tenant wizard fields
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'no_wa' => ['nullable', 'string', 'max:20'],
            'nisn_nbm' => ['nullable', 'string', 'max:30'],
            'nama_wali' => ['nullable', 'string', 'max:255'],
            'no_wa_wali' => ['nullable', 'string', 'max:20'],
            'tinggi_badan' => ['nullable', 'numeric'],
            'berat_badan' => ['nullable', 'numeric'],
            'golongan_darah' => ['nullable', 'string', 'max:20'],
        ]);

        $name = $validated['nama_lengkap'] ?? $validated['name'] ?? 'Siswa';

        $genderMap = [
            'Laki-laki' => 'L',
            'Perempuan' => 'P',
            'L' => 'L',
            'P' => 'P',
        ];

        $userData = [
            'name' => $name,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'sekolah_id' => $request->sekolah_id,
            'jenis_kelamin' => $genderMap[$validated['jenis_kelamin']] ?? 'P',
        ];

        // Map wizard fields to user model payload if present
        $extraFields = ['sekolah_id', 'no_wa', 'nisn_nbm', 'nama_wali', 'no_wa_wali', 'tinggi_badan', 'berat_badan', 'golongan_darah'];
        foreach ($extraFields as $field) {
            if (array_key_exists($field, $validated)) {
                $userData[$field] = $validated[$field];
            }
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('payment.activation');
    }
}
