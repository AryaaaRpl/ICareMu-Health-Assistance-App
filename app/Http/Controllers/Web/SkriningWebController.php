<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JadwalSkrining;
use App\Models\PesertaSkrining;
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
