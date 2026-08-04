<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MenstrualRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MenstrualHealthController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $isAdmin = in_array($user->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks']);

        // Jika admin, dapat memilih siswi perempuan dari dropdown
        $femaleStudents = collect();
        $selectedSiswaId = null;

        if ($isAdmin) {
            $femaleStudents = \App\Models\User::where('role', 'siswa')
                ->where('jenis_kelamin', 'P')
                ->orderBy('name', 'asc')
                ->get();

            // Jika ada query parameter student_id atau siswa_id, gunakan itu. Jika tidak, default ke siswi pertama
            $selectedSiswaId = $request->query('student_id', $request->query('siswa_id', $femaleStudents->first()?->id));
        } else {
            $selectedSiswaId = $user->id;
        }

        $records = collect();
        if ($selectedSiswaId) {
            $records = MenstrualRecord::where('siswa_id', $selectedSiswaId)
                        ->orderBy('tanggal_mulai', 'desc')
                        ->get();
        }

        $latestRecord = $records->first();
        
        // Inisialisasi variabel default
        $indikasiAmenore = false;
        $daysSinceLastPeriod = 0;
        $nextPeriodDate = null;
        $daysRemaining = 0;

        if ($latestRecord) {
            $lastDate = $latestRecord->tanggal_mulai;
            $now = Carbon::now();

            // Hitung estimasi haid berikutnya (Asumsi siklus rata-rata 28 hari)
            $nextPeriodDate = $lastDate->copy()->addDays(28);
            
            // Selisih hari dari haid terakhir sampai hari ini
            $daysSinceLastPeriod = (int) $lastDate->diffInDays($now, false);
            
            // Deteksi Amenore jika lebih dari 90 hari
            $indikasiAmenore = $daysSinceLastPeriod >= 90;
            
            // Hitung sisa hari menuju haid berikutnya (bisa minus kalau udah telat)
            $daysRemaining = (int) $now->diffInDays($nextPeriodDate, false);
        }

        // Mapping data untuk Alpine.js Calendar
        $calendarEvents = $records->map(function($rec) {
            return [
                'start' => $rec->tanggal_mulai->format('Y-m-d'),
                // Jika tanggal selesai kosong, anggap cuma 1 hari untuk tampilan kalender
                'end' => $rec->tanggal_selesai ? $rec->tanggal_selesai->format('Y-m-d') : $rec->tanggal_mulai->format('Y-m-d'),
            ];
        })->toArray();

        $selectedStudent = $isAdmin && $selectedSiswaId ? \App\Models\User::find($selectedSiswaId) : null;

        return view('menstrual.index', compact(
            'records', 
            'indikasiAmenore', 
            'daysSinceLastPeriod', 
            'nextPeriodDate', 
            'daysRemaining', 
            'calendarEvents',
            'isAdmin',
            'femaleStudents',
            'selectedSiswaId',
            'selectedStudent'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $isAdmin = in_array($user->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks']);

        if (!$isAdmin) {
            return redirect()->back()->with('error', 'Hanya Admin UKS atau Admin Super yang berwenang menginput data siklus haid.');
        }

        $targetSiswaId = $request->input('student_id') ?? $request->input('siswa_id');

        $validated = $request->validate([
            'student_id' => ['nullable', 'exists:users,id'],
            'siswa_id' => ['nullable', 'exists:users,id'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'tingkat_nyeri' => ['required', 'integer', 'min:1', 'max:5'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        if (!$targetSiswaId) {
            return redirect()->back()->with('error', 'Siswi belum dipilih.');
        }

        // Pastikan target siswa adalah perempuan
        $targetSiswa = \App\Models\User::findOrFail($targetSiswaId);
        if ($targetSiswa->jenis_kelamin !== 'P') {
            return redirect()->back()->with('error', 'Pencatatan haid hanya berlaku untuk siswa perempuan.');
        }

        MenstrualRecord::create([
            'siswa_id' => $targetSiswa->id,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            'tingkat_nyeri' => $validated['tingkat_nyeri'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('menstrual.index', ['student_id' => $targetSiswa->id, 'siswa_id' => $targetSiswa->id])
            ->with('success', 'Catatan siklus haid berhasil disimpan untuk ' . $targetSiswa->name);
    }

    public function finish(Request $request, MenstrualRecord $record): RedirectResponse
    {
        $user = auth()->user();
        $isAdmin = in_array($user->role, ['super_admin', 'admin_super', 'admin_uks', 'petugas_uks']);

        if (!$isAdmin) {
            return redirect()->back()->with('error', 'Hanya Admin UKS atau Admin Super yang berwenang memperbarui tanggal selesai haid.');
        }

        $validated = $request->validate([
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:' . $record->tanggal_mulai->format('Y-m-d')],
        ]);

        $record->update([
            'tanggal_selesai' => $validated['tanggal_selesai'],
        ]);

        return redirect()->route('menstrual.index', ['siswa_id' => $record->siswa_id])
            ->with('success', 'Tanggal selesai haid berhasil diperbarui.');
    }
}