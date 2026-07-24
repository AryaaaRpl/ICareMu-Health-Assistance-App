<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SkriningRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkriningController extends Controller
{
    /**
     * Store a newly created screening record from the student form.
     */
    public function storeStudent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'suhu_tubuh' => ['required', 'numeric', 'min:34', 'max:45'],
            'gejala' => ['nullable', 'array'],
            'keluhan_tambahan' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;

        $skrining = SkriningRecord::create([
            'siswa_id' => $user->id,
            'sekolah_id' => $sekolahId,
            'suhu_tubuh' => (float) $validated['suhu_tubuh'],
            'gejala' => $validated['gejala'] ?? [],
            'keluhan_tambahan' => $validated['keluhan_tambahan'] ?? null,
            'ai_status' => null,
            'ai_recommendation' => null,
        ]);

        // TODO: [AI TEAM] - Fetch this data, send to your AI model, and update ai_status and ai_recommendation.

        return redirect()->route('dashboard')->with('success', 'Data skrining berhasil dikirim dan sedang dianalisis.');
    }

    /**
     * Alias method for general store endpoint.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->storeStudent($request);
    }

    /**
     * Display the specified screening record detail for UKS Admin.
     */
    public function show(SkriningRecord $skrining): View
    {
        $skrining->load('siswa');
        return view('uks.detail-skrining', compact('skrining'));
    }

    /**
     * Update UKS medical treatment & status for the screening record.
     */
    public function updateTindakan(Request $request, SkriningRecord $skrining): RedirectResponse
    {
        $validated = $request->validate([
            'tindakan_uks' => ['required', 'string'],
            'obat_diberikan' => ['nullable', 'string', 'max:255'],
            'status_akhir' => ['required', 'in:kembali_ke_kelas,istirahat_di_uks,pulang,rujuk_rs'],
        ]);

        $skrining->update([
            'tindakan_uks' => $validated['tindakan_uks'],
            'obat_diberikan' => $validated['obat_diberikan'] ?? null,
            'waktu_ditindak' => now(),
            'status_akhir' => $validated['status_akhir'],
        ]);

        return redirect()->route('dashboard.uks')->with('success', 'Tindakan UKS & Rekam Medis berhasil diperbarui!');
    }

    /**
     * Display the screening schedules and student list for UKS Admin.
     */
    public function indexJadwal(): View
    {
        $user = auth()->user();
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;

        // Fetch real data from database
        $jadwalSkrining = \App\Models\JadwalSkrining::latest()->get();
        if ($jadwalSkrining->isEmpty()) {
            $jadwalSkrining = \App\Models\JadwalSkrining::withoutGlobalScopes()->latest()->get();
        }
        $jadwals = $jadwalSkrining;

        // Fetch students for the "Input Hasil Skrining" dropdown
        $siswas = \App\Models\User::where('role', 'siswa')->get();
        if ($siswas->isEmpty()) {
            $siswas = \App\Models\Siswa::withoutGlobalScopes()->get();
        }
        if ($siswas->isEmpty()) {
            $siswas = \App\Models\User::all();
        }

        $viewName = view()->exists('admin.skrining') ? 'admin.skrining' : 'skrining.index';

        return view($viewName, compact('jadwalSkrining', 'jadwals', 'siswas'));
    }

    /**
     * Store a newly created screening schedule (JadwalSkrining).
     */
    public function storeJadwal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_skrining' => ['required', 'string', 'max:255'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
        ]);

        $user = auth()->user();

        // Fallback safety for sekolah_id
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id');

        if (!$sekolahId) {
            return back()->withErrors(['lokasi' => 'Gagal menyimpan: Tidak ada data Sekolah/Tenant yang aktif untuk user ini.']);
        }

        \App\Models\JadwalSkrining::create([
            'sekolah_id' => $sekolahId,
            'jenis_skrining' => $validated['jenis_skrining'],
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],
            'lokasi' => $validated['lokasi'],
            'status' => 'Terjadwal',
        ]);

        return back()->with('success', 'Jadwal Skrining berhasil disimpan.');
    }

    /**
     * Store a newly registered screening participant & results (PesertaSkrining).
     */
    public function storePeserta(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jadwal_id' => ['nullable'],
            'jadwal_skrining_id' => ['nullable'],
            'siswa_id' => ['required'],
            'status_kehadiran' => ['nullable', 'string'],
            'catatan_hasil' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $sekolahId = $user->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;
        $jadwalId = (int) ($validated['jadwal_id'] ?? $validated['jadwal_skrining_id'] ?? 1);

        $payload = [
            'sekolah_id' => $sekolahId,
            'jadwal_id' => $jadwalId,
            'jadwal_skrining_id' => $jadwalId,
            'siswa_id' => $validated['siswa_id'],
            'status_kehadiran' => $validated['status_kehadiran'] ?? 'Hadir',
            'catatan_hasil' => $validated['catatan_hasil'] ?? $validated['catatan'] ?? null,
            'catatan' => $validated['catatan_hasil'] ?? $validated['catatan'] ?? null,
        ];

        \App\Models\PesertaSkrining::create($payload);

        return back()->with('success', 'Peserta & Hasil Skrining berhasil disimpan.');
    }
}
