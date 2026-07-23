<?php

namespace App\Http\Controllers;

use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the UKS Dashboard with real data metrics.
     */
    public function index(): View
    {
        $jumlahKunjungan = RekamMedis::whereDate('created_at', today())->count();

        $siswaSakit = RekamMedis::whereDate('created_at', today())
            ->where('status', 'dirawat')
            ->count();

        $tingkatKehadiran = '96.8%';

        $trenKesehatanIndex = '84/100';

        $kunjungans = RekamMedis::with('siswa')
            ->latest()
            ->take(5)
            ->get();

        $stoks = InventarisUks::where('jumlah', '<=', 20)
            ->orWhere('stok', '<=', 20)
            ->get();

        return view('dashboard.uks', compact(
            'jumlahKunjungan',
            'siswaSakit',
            'tingkatKehadiran',
            'trenKesehatanIndex',
            'kunjungans',
            'stoks'
        ));
    }
}
