<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JadwalSkrining;
use App\Models\PesertaSkrining;
use App\Models\SkriningRecord;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkriningWebController extends Controller
{
    /**
     * Display screening schedules list.
     */
    public function index(): View
    {
        $jadwal_skrining = class_exists(JadwalSkrining::class) ? JadwalSkrining::latest()->get() : collect();
        $jadwals = $jadwal_skrining;
        $siswas = class_exists(User::class) ? User::all() : collect();

        return view('skrining.index', compact('jadwal_skrining', 'jadwals', 'siswas'));
    }

    /**
     * Display daily student health screening form.
     */
    public function createSiswa(): View
    {
        return view('siswa.skrining');
    }

    /**
     * Store daily student health screening record.
     */
    public function storeSiswa(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'suhu_tubuh' => ['required', 'numeric', 'min:34', 'max:45'],
            'gejala' => ['nullable', 'array'],
            'tekanan_darah' => ['nullable', 'string', 'max:50'],
            'catatan_keluhan' => ['nullable', 'string', 'max:1000'],
        ]);

        $suhu = (float) $validated['suhu_tubuh'];
        $gejala = $request->input('gejala', []);
        $keluhanStr = is_array($gejala) ? implode(', ', $gejala) : ($gejala ?? '');

        if ($request->filled('catatan_keluhan')) {
            $keluhanStr .= ($keluhanStr ? ' - ' : '') . $request->input('catatan_keluhan');
        }

        // Calculate health status
        $statusKesehatan = 'sehat';
        if ($suhu >= 38.0 || in_array('Demam', $gejala) || in_array('Mual', $gejala)) {
            $statusKesehatan = 'butuh_penanganan';
        } elseif ($suhu >= 37.3 || (count($gejala) > 0 && !in_array('Tidak Ada', $gejala))) {
            $statusKesehatan = 'sakit_ringan';
        }

        if (class_exists(SkriningRecord::class)) {
            SkriningRecord::create([
                'siswa_id' => auth()->id(),
                'sekolah_id' => auth()->user()->sekolah_id ?? null,
                'suhu_tubuh' => $suhu,
                'tekanan_darah' => $validated['tekanan_darah'] ?? null,
                'keluhan' => $keluhanStr ?: 'Tidak Ada',
                'status_kesehatan' => $statusKesehatan,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Skrining berhasil dicatat!');
    }

    /**
     * Store a newly created screening schedule (JadwalSkrining).
     */
    public function storeJadwal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_skrining' => ['nullable', 'string', 'max:255'],
            'nama_kegiatan' => ['nullable', 'string', 'max:255'],
            'tanggal_pelaksanaan' => ['nullable', 'date'],
            'tanggal' => ['nullable', 'date'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
        ]);

        // Map inputs for compatibility
        $payload = [
            'jenis_skrining' => $validated['jenis_skrining'] ?? $validated['nama_kegiatan'] ?? 'Skrining Umum',
            'nama_kegiatan' => $validated['nama_kegiatan'] ?? $validated['jenis_skrining'] ?? 'Skrining Umum',
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'] ?? $validated['tanggal'] ?? now()->toDateString(),
            'tanggal' => $validated['tanggal'] ?? $validated['tanggal_pelaksanaan'] ?? now()->toDateString(),
            'lokasi' => $validated['lokasi'] ?? 'Ruang UKS',
            'keterangan' => $validated['keterangan'] ?? null,
        ];

        if (class_exists(JadwalSkrining::class)) {
            JadwalSkrining::create($payload);
        }

        return redirect()->back()->with('success', 'Jadwal Skrining berhasil disimpan.');
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

        $payload = [
            'jadwal_skrining_id' => $validated['jadwal_id'] ?? $validated['jadwal_skrining_id'] ?? 1,
            'siswa_id' => $validated['siswa_id'],
            'status_kehadiran' => $validated['status_kehadiran'] ?? 'Hadir',
            'catatan_hasil' => $validated['catatan_hasil'] ?? $validated['catatan'] ?? null,
            'catatan' => $validated['catatan_hasil'] ?? $validated['catatan'] ?? null,
        ];

        if (class_exists(PesertaSkrining::class)) {
            PesertaSkrining::create($payload);
        }

        return redirect()->back()->with('success', 'Peserta & Hasil Skrining berhasil disimpan.');
    }
}
