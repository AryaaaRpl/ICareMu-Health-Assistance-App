<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\PesertaSkrining;
use App\Models\SkriningRecord;
use App\Models\User;
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
        $obat = InventarisUks::where('kategori', 'Obat')
            ->where('stok', '>', 0)
            ->get();

        return view('uks.detail-skrining', compact('skrining', 'obat'));
    }

    /**
     * Update UKS medical treatment & status for the screening record.
     */
    public function updateTindakan(Request $request, SkriningRecord $skrining): RedirectResponse
    {
        $validated = $request->validate([
            'tindakan_uks' => ['required', 'string'],
            'inventaris_id' => ['nullable', 'array'],
            'inventaris_id.*' => ['exists:inventaris_uks,id'],
            'status_akhir' => ['required', 'in:kembali_ke_kelas,istirahat_di_uks,pulang,rujuk_rs'],
        ]);

        $obatNames = [];

        if (!empty($validated['inventaris_id'])) {
            $selectedItems = InventarisUks::whereIn('id', $validated['inventaris_id'])->get();

            foreach ($selectedItems as $item) {
                if ($item->stok > 0) {
                    $item->decrement('stok', 1);
                    $obatNames[] = $item->nama_barang;
                }
            }
        }

        $obatText = !empty($obatNames) ? implode(', ', $obatNames) : null;

        $skrining->update([
            'tindakan_uks' => $validated['tindakan_uks'],
            'obat_diberikan' => $obatText,
            'waktu_ditindak' => now(),
            'status_akhir' => $validated['status_akhir'],
            'admin_id' => auth()->id(),
        ]);

        // Also sync/create Smart Health Record (RekamMedis) for the student
        if (class_exists(\App\Models\RekamMedis::class) && $skrining->siswa_id) {
            \App\Models\RekamMedis::create([
                'sekolah_id' => $skrining->sekolah_id ?? auth()->user()->sekolah_id ?? 1,
                'siswa_id' => $skrining->siswa_id,
                'keluhan_utama' => is_array($skrining->gejala) ? implode(', ', $skrining->gejala) : ($skrining->keluhan_tambahan ?? 'Pemeriksaan UKS'),
                'suhu' => $skrining->suhu_tubuh ?? 36.5,
                'status_risiko' => $skrining->ai_status ?? 'sedang',
                'status_penanganan' => $validated['status_akhir'],
                'penanganan' => $validated['tindakan_uks'],
                'catatan_medis' => $validated['tindakan_uks'] . ($obatText ? " | Obat: {$obatText}" : ''),
                'tanggal' => now()->toDateString(),
            ]);
        }

        return redirect()->route('dashboard.uks')->with('success', 'Tindakan UKS & Rekam Medis berhasil diperbarui!');
    }

    public function index(Request $request): View
    {
        $sekolahId = auth()->user()->sekolah_id;

        $skriningRecords = SkriningRecord::with('siswa')
            ->where('sekolah_id', $sekolahId)
            ->when($request->input('kelas'), fn($q, $kelas) => $q->whereHas('siswa', fn($sq) => $sq->where('kelas', $kelas)))
            ->when($request->input('search'), fn($q, $search) => $q->whereHas('siswa', fn($sq) => $sq->where('name', 'like', "%{$search}%")))
            ->latest()
            ->paginate(10);

        $siswas = class_exists(User::class) ? User::where('role', 'siswa')->get() : collect();
        $jadwals = class_exists(JadwalSkrining::class) ? JadwalSkrining::latest()->get() : collect();

        return view('skrining.index', compact('skriningRecords', 'siswas', 'jadwals'));
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
            'siswa_id'          => ['required', 'integer', 'exists:users,id'],
            'jadwal_id'         => ['required', 'integer', 'exists:jadwal_skrining,id'],
            'status_kehadiran'  => ['required', 'string', 'in:Hadir,Tidak Hadir,Izin,Sakit'],
            'catatan_hasil'     => ['nullable', 'string', 'max:5000'],
        ]);

        $sekolahId = auth()->user()->sekolah_id ?? \App\Models\Sekolah::value('id') ?? 1;

        PesertaSkrining::create([
            'sekolah_id'         => $sekolahId,
            'jadwal_id'          => $validated['jadwal_id'],
            'jadwal_skrining_id' => $validated['jadwal_id'],
            'siswa_id'           => $validated['siswa_id'],
            'status_kehadiran'   => $validated['status_kehadiran'],
            'catatan_hasil'      => $validated['catatan_hasil'] ?? null,
            'catatan'            => $validated['catatan_hasil'] ?? null,
            'admin_id'           => auth()->id(),
        ]);

        return redirect()->route('skrining.index')->with('success', 'Hasil skrining berhasil dicatat.');
    }
}
