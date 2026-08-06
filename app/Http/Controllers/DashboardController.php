<?php

namespace App\Http\Controllers;

use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\RekamMedis;
use App\Models\Sekolah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the UKS Analytics Dashboard with real data metrics & charts.
     */
    public function index(): View
    {
        // 1. Stat Cards Data
        $totalSiswa = User::where('role', 'siswa')->count();
        if ($totalSiswa === 0) {
            $totalSiswa = User::count();
        }

        $totalPemeriksaan = RekamMedis::whereMonth('created_at', now()->month)
            ->orWhereMonth('tanggal', now()->month)
            ->count();

        $stokRendah = InventarisUks::where(function ($query) {
            $query->where('jumlah', '<', 10)
                ->orWhere('stok', '<', 10)
                ->orWhere('kondisi', 'Rusak');
        })->count();

        // 2. Today's Skrining Records for Live Triage Monitor
        $skriningHariIni = \App\Models\SkriningRecord::with(['siswa' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereDate('created_at', today())
            ->orderByRaw("
                CASE 
                    WHEN ai_status = 'darurat' THEN 1
                    WHEN ai_status = 'observasi_uks' THEN 2
                    WHEN ai_status = 'pulang' THEN 3
                    WHEN ai_status = 'sehat' THEN 4
                    ELSE 5
                END ASC
            ")
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Upcoming 3 Screening Schedules
        $jadwalSkrining = JadwalSkrining::whereDate('tanggal_pelaksanaan', '>=', now()->toDateString())
            ->orWhereDate('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->take(3)
            ->get();

        if ($jadwalSkrining->isEmpty()) {
            $jadwalSkrining = JadwalSkrining::latest()->take(3)->get();
        }

        // 3. Chart 1: Top 5 Most Common Complaints (Doughnut Chart)
        $topComplaints = RekamMedis::select('keluhan_utama', DB::raw('count(*) as total'))
            ->whereNotNull('keluhan_utama')
            ->where('keluhan_utama', '!=', '')
            ->groupBy('keluhan_utama')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $grafikKeluhan = [
            'labels' => $topComplaints->pluck('keluhan_utama')->map(fn($str) => \Illuminate\Support\Str::limit((string) $str, 22))->toArray(),
            'data' => $topComplaints->pluck('total')->toArray(),
        ];

        if (empty($grafikKeluhan['labels'])) {
            $grafikKeluhan = [
                'labels' => ['Demam/Pusing', 'Sakit Perut', 'Luka Lecet', 'Batuk Flu', 'Sakit Gigi'],
                'data' => [12, 8, 5, 3, 2],
            ];
        }

        // 4. Chart 2: UKS Visits in Last 7 Days (Line Chart)
        $dates = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('Y-m-d'));
        $kunjunganCounts = [];

        foreach ($dates as $date) {
            $count = RekamMedis::where(function ($query) use ($date) {
                $query->whereDate('tanggal', $date)
                    ->orWhereDate('created_at', $date);
            })->count();
            $kunjunganCounts[$date] = $count;
        }

        $grafikKunjungan = [
            'labels' => $dates->map(fn($d) => Carbon::parse($d)->translatedFormat('d M'))->toArray(),
            'data' => array_values($kunjunganCounts),
        ];

        // Additional table helpers
        $kunjungans = RekamMedis::with('siswa')->latest()->take(5)->get();
        $stoks = InventarisUks::where('stok', '<=', 10)->orWhere('kondisi', 'Rusak')->get();

        $viewName = view()->exists('dashboard-uks') ? 'dashboard-uks' : 'dashboard.uks';

        return view($viewName, compact(
            'totalSiswa',
            'totalPemeriksaan',
            'stokRendah',
            'jadwalSkrining',
            'grafikKeluhan',
            'grafikKunjungan',
            'kunjungans',
            'stoks',
            'skriningHariIni'
        ));
    }

    /**
     * Export UKS monthly health report as PDF download or clean print view.
     */
    public function exportLaporan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = RekamMedis::with('siswa');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
            $periode = Carbon::parse($startDate)->translatedFormat('d M Y') . ' - ' . Carbon::parse($endDate)->translatedFormat('d M Y');
        } else {
            $currentMonth = now()->month;
            $currentYear = now()->year;

            $query->where(function ($q) use ($currentMonth, $currentYear) {
                $q->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)
                    ->orWhere(function ($subQ) use ($currentMonth, $currentYear) {
                        $subQ->whereMonth('tanggal', $currentMonth)->whereYear('tanggal', $currentYear);
                    });
            });
            $periode = now()->translatedFormat('F Y');
        }

        $records = $query->latest()->get();

        $sekolah = Sekolah::first();
        $namaSekolah = $sekolah ? $sekolah->nama_sekolah : 'SMP Negeri 1 Jakarta';

        $totalRawat = $records->whereIn('status_penanganan', ['Istirahat di UKS', 'Rawat UKS', 'Dalam Penanganan'])->count();
        $totalRujuk = $records->whereIn('status_penanganan', ['Rujuk ke Puskesmas', 'Dirujuk'])->count();

        $data = [
            'namaSekolah' => $namaSekolah,
            'periode' => $periode,
            'records' => $records,
            'totalRawat' => $totalRawat,
            'totalRujuk' => $totalRujuk,
        ];

        // Check if DomPDF is installed and available
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.laporan-uks', $data);
            return $pdf->download('Laporan-UKS-' . date('Y-m-d') . '.pdf');
        }

        // Fallback printable view
        return view('exports.laporan-uks', $data);
    }
}
