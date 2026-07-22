<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CheckAmenoreEarlyWarningAction;

use App\Models\JadwalSkrining;
use App\Models\KesehatanReproduksi;
use App\Models\RekamMedis;
use App\Models\RiwayatKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $siswa = $user?->siswa;

        if (!$siswa) {
            return view('pages.dashboard-siswa', [
                'user' => $user,
                'siswa' => null,
                'latestMedis' => null,
                'nextSkrining' => null,
                'lastHaid' => null,
                'amenoreWarning' => null,
                'riwayatKonsultasi' => collect(),
            ]);
        }

        $latestMedis = RekamMedis::where('siswa_id', $siswa->id)
            ->latest('tanggal_periksa')
            ->first();

        $nextSkrining = JadwalSkrining::where('sekolah_id', $siswa->sekolah_id)
            ->where('status', 'PENDING')
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->first();

        $lastHaid = KesehatanReproduksi::where('siswa_id', $siswa->id)
            ->latest('tanggal_haid')
            ->first();

        $amenoreAction = new CheckAmenoreEarlyWarningAction();
        $amenoreWarning = $amenoreAction->execute($lastHaid?->tanggal_haid);

        $riwayatKonsultasi = RiwayatKonsultasi::where('siswa_id', $siswa->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard-siswa', compact(
            'user',
            'siswa',
            'latestMedis',
            'nextSkrining',
            'lastHaid',
            'amenoreWarning',
            'riwayatKonsultasi'
        ));
    }
}
