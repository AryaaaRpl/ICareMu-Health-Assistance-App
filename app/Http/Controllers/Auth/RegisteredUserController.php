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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request (3-step wizard).
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Step 1: Standard account credentials
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Step 2 & 3: Additional student & tenant wizard fields
            'sekolah_id' => ['nullable', 'integer'],
            'nisn' => ['nullable', 'string', 'max:20'],
            'nama_wali' => ['nullable', 'string', 'max:255'],
            'no_wa_wali' => ['nullable', 'string', 'max:20'],
            'tinggi_badan' => ['nullable', 'numeric'],
            'berat_badan' => ['nullable', 'numeric'],
            'golongan_darah' => ['nullable', 'string', 'max:5'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        // Map wizard fields to user model payload if present
        $extraFields = ['sekolah_id', 'nisn', 'nama_wali', 'no_wa_wali', 'tinggi_badan', 'berat_badan', 'golongan_darah'];
        foreach ($extraFields as $field) {
            if (array_key_exists($field, $validated)) {
                $userData[$field] = $validated[$field];
            }
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.uks'));
    }
}
