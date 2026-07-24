<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\User;
use App\Services\Health\IMTCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekamMedisWebController extends Controller
{
    /**
     * Display a listing of medical records for the current tenant.
     */
    public function index(): View
    {
        $records = \App\Models\SkriningRecord::with('siswa')->latest()->get();
        $rekam_medis = $records;

        $totalSkrining = $records->count();
        $statusNormal = $records->whereIn('ai_status', ['sehat'])->count();
        $perluPerhatian = $records->filter(fn($r) => (float)$r->suhu_tubuh > 37.5 || in_array($r->ai_status, ['observasi_uks', 'darurat']))->count();
        $tindakanDirujuk = $records->whereIn('status_akhir', ['rujuk_rs'])->count();

        $siswaList = User::where('role', 'siswa')->orderBy('name', 'asc')->get();
        if ($siswaList->isEmpty()) {
            $siswaList = User::orderBy('name', 'asc')->get();
        }
        $siswas = $siswaList;

        return view('rekam-medis.index', compact(
            'records',
            'rekam_medis',
            'totalSkrining',
            'statusNormal',
            'perluPerhatian',
            'tindakanDirujuk',
            'siswas',
            'siswaList'
        ));
    }

    /**
     * Store a newly created medical record.
     */
    public function store(Request $request, IMTCalculatorService $imtService): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:users,id'],
            'suhu' => ['required', 'numeric', 'min:34', 'max:45'],
            'keluhan_utama' => ['required', 'string'],
            'penanganan' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'tinggi_badan' => ['nullable', 'numeric'],
            'berat_badan' => ['nullable', 'numeric'],
        ]);

        $statusAkhirMap = [
            'Istirahat di UKS' => 'istirahat_di_uks',
            'Diberi Obat' => 'istirahat_di_uks',
            'Dirujuk ke Rumah Sakit / Puskesmas' => 'rujuk_rs',
            'Dirujuk' => 'rujuk_rs',
            'Selesai / Sehat' => 'kembali_ke_kelas',
            'Selesai' => 'kembali_ke_kelas',
        ];

        $statusInput = $validated['status'] ?? 'Selesai / Sehat';
        $statusAkhir = $statusAkhirMap[$statusInput] ?? 'kembali_ke_kelas';

        // Retrieve student user or fallback sekolah_id
        $studentUser = User::find($validated['siswa_id']);
        $sekolahId = $studentUser->sekolah_id ?? auth()->user()->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;

        // Also create SkriningRecord to integrate with Triage and Health Record
        $skrining = \App\Models\SkriningRecord::create([
            'siswa_id' => $validated['siswa_id'],
            'sekolah_id' => $sekolahId,
            'suhu_tubuh' => (float) $validated['suhu'],
            'gejala' => [$validated['keluhan_utama']],
            'keluhan_tambahan' => $validated['keluhan_utama'],
            'ai_status' => (float)$validated['suhu'] >= 38.0 ? 'observasi_uks' : ((float)$validated['suhu'] >= 37.3 ? 'pulang' : 'sehat'),
            'ai_recommendation' => 'Pemeriksaan fisik oleh Petugas UKS.',
            'tindakan_uks' => $validated['penanganan'] ?? 'Pemeriksaan standar UKS',
            'waktu_ditindak' => now(),
            'status_akhir' => $statusAkhir,
        ]);

        // Also save to RekamMedis if exists
        if (class_exists(RekamMedis::class)) {
            $tinggiBadan = (float) ($validated['tinggi_badan'] ?? 165);
            $beratBadan = (float) ($validated['berat_badan'] ?? 55);
            $imtData = $imtService->calculate($beratBadan, $tinggiBadan);

            RekamMedis::create([
                'sekolah_id' => $sekolahId,
                'siswa_id' => $validated['siswa_id'],
                'tinggi_badan' => $tinggiBadan,
                'berat_badan' => $beratBadan,
                'suhu' => (float) $validated['suhu'],
                'tekanan_darah' => $request->input('tekanan_darah', '120/80'),
                'keluhan_utama' => $validated['keluhan_utama'],
                'penanganan' => $validated['penanganan'] ?? null,
                'status' => $statusInput,
                'imt_score' => $imtData['imt_score'],
                'status_risiko' => $imtData['status_risiko'],
                'tanggal' => now()->toDateString(),
            ]);
        }

        return redirect()->back()->with('success', 'Data rekam medis & skrining berhasil disimpan.');
    }
}
