<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Models\SkriningRecord;
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
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = RekamMedis::with('siswa')
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('siswa', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                          ->orWhere('nisn_nbm', 'like', "%{$search}%");
                    })
                    ->orWhere('keluhan_utama', 'like', "%{$search}%")
                    ->orWhere('penanganan', 'like', "%{$search}%");
                });
            })
            ->when($statusFilter, function ($q, $status) {
                $q->where('status', $status);
            });

        $records = $query->latest()->paginate(10);
        $rekam_medis = $records;

        $totalSkrining = $records->total();
        $statusNormal = RekamMedis::whereIn('status', ['Selesai', 'Selesai / Sehat'])->count();
        $perluPerhatian = RekamMedis::get()->filter(fn($r) => (float)$r->suhu > 37.5 || in_array($r->status, ['Istirahat di UKS', 'Diberi Obat']))->count();
        $tindakanDirujuk = RekamMedis::whereIn('status', ['Dirujuk', 'Dirujuk ke Rumah Sakit / Puskesmas'])->count();

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
            'siswaList',
        ));
    }

    /**
     * Display a read-only detail view of a single screening record.
     */
    public function show($id): View
    {
        
        $record = RekamMedis::with('siswa', 'admin')->find($id);

    // Kasih jebakan batman
    if (!$record) {
        // dd("Skakmat! Data dengan ID {$id} beneran GAK ADA di database brok!");
    }
        return view('rekam-medis.show', compact('record'));
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
            'tinggi_badan' => ['required', 'numeric', 'min:30', 'max:250'],
            'berat_badan' => ['required', 'numeric', 'min:2', 'max:300'],
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
            $tinggiBadan = (float) $validated['tinggi_badan'];
            $beratBadan = (float) $validated['berat_badan'];
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
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Data rekam medis & skrining berhasil disimpan.');
    }
}
