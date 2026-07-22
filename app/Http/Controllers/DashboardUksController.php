<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\RekamMedis;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUksController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $sekolahId = $user->sekolah_id ?? 1;

        $totalSiswa = Siswa::where('sekolah_id', $sekolahId)->count();
        $totalKunjungan = RekamMedis::where('sekolah_id', $sekolahId)->count();

        $siswaSakitHariIni = RekamMedis::where('sekolah_id', $sekolahId)
            ->whereDate('tanggal_periksa', now()->toDateString())
            ->count();

        $lowStockInventory = InventarisUks::where('sekolah_id', $sekolahId)
            ->where('stok', '<=', 10)
            ->get();

        $recentRekamMedis = RekamMedis::with('siswa')
            ->where('sekolah_id', $sekolahId)
            ->latest('tanggal_periksa')
            ->take(10)
            ->get();

        $pendingSkrining = JadwalSkrining::where('sekolah_id', $sekolahId)
            ->where('status', 'PENDING')
            ->latest('tanggal_pelaksanaan')
            ->get();

        $riskBreakdown = [
            'normal' => RekamMedis::where('sekolah_id', $sekolahId)->where('status_risiko', 'Normal')->count(),
            'ringan' => RekamMedis::where('sekolah_id', $sekolahId)->where('status_risiko', 'LIKE', '%Ringan%')->count(),
            'tinggi' => RekamMedis::where('sekolah_id', $sekolahId)->where('status_risiko', 'LIKE', '%Tinggi%')->orWhere('status_risiko', 'LIKE', '%Obesitas%')->count(),
        ];

        return view('pages.dashboard-uks', compact(
            'user',
            'totalSiswa',
            'totalKunjungan',
            'siswaSakitHariIni',
            'lowStockInventory',
            'recentRekamMedis',
            'pendingSkrining',
            'riskBreakdown'
        ));
    }
}
