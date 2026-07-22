<?php

namespace App\Http\Controllers;

use App\Actions\CalculateImtAction;

use App\Models\RekamMedis;
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
            'credential' => 'Kredensial (NISN / Email / Password) yang Anda masukkan salah.',
        ])->onlyInput('credential');
    }

    public function showRegisterStep1()
    {
        $sekolahs = Sekolah::all();
        return view('auth.register-step1', compact('sekolahs'));
    }

    public function processRegisterStep1(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:255|unique:siswas,nisn',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'sekolah_id' => 'required|exists:sekolahs,id',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'siswa',
            'sekolah_id' => $request->input('sekolah_id'),
            'payment_status' => 'pending',
            'payment_order_id' => 'ORDER-' . strtoupper(uniqid()),
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'sekolah_id' => $request->input('sekolah_id'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nisn' => $request->input('nisn'),
            'tanggal_lahir' => now()->subYears(16)->toDateString(),
        ]);

        Auth::login($user);

        return redirect()->route('register.step2');
    }

    public function showRegisterStep2()
    {
        $user = Auth::user();
        return view('auth.register-step2', compact('user'));
    }

    public function processRegisterStep2(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->update([
                'payment_status' => 'paid',
            ]);
        }

        return redirect()->route('register.step3');
    }

    public function showRegisterStep3()
    {
        $user = Auth::user();
        $siswa = $user?->siswa;
        return view('auth.register-step3', compact('user', 'siswa'));
    }

    public function processRegisterStep3(Request $request)
    {
        $request->validate([
            'nama_ortu' => 'required|string|max:255',
            'no_wa_ortu' => 'required|string|max:20',
            'tinggi_badan' => 'required|numeric|min:30|max:250',
            'berat_badan' => 'required|numeric|min:5|max:300',
            'golongan_darah' => 'nullable|string|in:A,B,AB,O',
        ]);

        $user = Auth::user();
        $siswa = $user?->siswa;

        if ($siswa) {
            $siswa->update([
                'nama_ortu' => $request->input('nama_ortu'),
                'no_wa_ortu' => $request->input('no_wa_ortu'),
                'golongan_darah' => $request->input('golongan_darah'),
            ]);

            $action = new CalculateImtAction();
            $imtResult = $action->execute(
                (float) $request->input('tinggi_badan'),
                (float) $request->input('berat_badan')
            );

            RekamMedis::create([
                'siswa_id' => $siswa->id,
                'sekolah_id' => $siswa->sekolah_id,
                'created_by' => $user->id,
                'tanggal_periksa' => now()->toDateString(),
                'tinggi_badan' => $request->input('tinggi_badan'),
                'berat_badan' => $request->input('berat_badan'),
                'imt_score' => $imtResult['imt'],
                'status_risiko' => $imtResult['status_risiko'],
                'catatan_medis' => 'Pemeriksaan Kesehatan Awal Registrasi Siswa.',
                'status_verifikasi' => 'Terverifikasi',
            ]);
        }

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
