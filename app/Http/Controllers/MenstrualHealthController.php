<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CheckAmenoreEarlyWarningAction;

use App\Models\KesehatanReproduksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenstrualHealthController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa && $user->role !== 'siswa') {
            // For UKS Admin / Teachers, pick first student or view all
            $siswa = Siswa::where('sekolah_id', $user->sekolah_id ?? 1)->first();
        }

        $logs = $siswa
            ? KesehatanReproduksi::where('siswa_id', $siswa->id)->latest('tanggal_haid')->get()
            : collect();

        $latestLog = $logs->first();

        $earlyWarningAction = new CheckAmenoreEarlyWarningAction();
        $earlyWarning = $earlyWarningAction->execute($latestLog?->tanggal_haid);

        return view('pages.menstrual-health', compact('user', 'siswa', 'logs', 'latestLog', 'earlyWarning'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_haid' => 'required|date',
        ]);

        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            return back()->withErrors(['siswa' => 'Data profil siswa tidak ditemukan.']);
        }

        $earlyWarningAction = new CheckAmenoreEarlyWarningAction();
        $warningResult = $earlyWarningAction->execute($request->input('tanggal_haid'));

        KesehatanReproduksi::create([
            'siswa_id' => $siswa->id,
            'sekolah_id' => $siswa->sekolah_id,
            'tanggal_haid' => $request->input('tanggal_haid'),
            'status_ai_amenore' => $warningResult['status'],
        ]);

        return redirect()->route('menstrual.health')->with('success', 'Pencatatan siklus menstruasi berhasil disimpan.');
    }
}
