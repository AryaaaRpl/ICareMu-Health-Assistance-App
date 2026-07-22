<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'credential' => 'required|string',
            'password' => 'required|string',
        ]);

        $credential = $request->input('credential');
        $password = $request->input('password');

        if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => $credential, 'password' => $password])) {
                $request->session()->regenerate();
                return $this->redirectBasedOnRole();
            }
        } else {
            $siswa = Siswa::where('nisn', $credential)->first();
            if ($siswa && $siswa->user) {
                if (Hash::check($password, $siswa->user->password)) {
                    Auth::login($siswa->user);
                    $request->session()->regenerate();
                    return $this->redirectBasedOnRole();
                }
            }
        }
        
        return back()->withErrors([
            'credential' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('credential');
    }

    public function showRegister()
    {
        $sekolahs = Sekolah::all();
        return view('auth.register', compact('sekolahs'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:255|unique:siswas,nisn',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
            'tanggal_lahir' => 'required|date',
            'nama_ortu' => 'nullable|string|max:255',
            'no_wa_ortu' => 'nullable|string|max:20',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'siswa',
            'sekolah_id' => $request->input('sekolah_id'),
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'sekolah_id' => $request->input('sekolah_id'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nisn' => $request->input('nisn'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'nama_ortu' => $request->input('nama_ortu'),
            'no_wa_ortu' => $request->input('no_wa_ortu'),
            'golongan_darah' => $request->input('golongan_darah'),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.siswa');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    private function redirectBasedOnRole()
    {
        $role = auth()->user()->role;
        switch ($role) {
            case 'siswa':
            case 'ortu':
                return redirect()->route('dashboard.siswa');
            case 'guru_uks':
            case 'admin_sekolah':
            case 'admin_super':
                return redirect()->route('dashboard.uks');
            default:
                return redirect()->route('dashboard.siswa');
        }
    }
}
