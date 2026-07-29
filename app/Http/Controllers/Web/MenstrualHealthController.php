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
    public function index(): View
    {
        // Hanya tarik data milik siswa yang login (IDOR protection)
        $records = MenstrualRecord::where('siswa_id', auth()->id())
                    ->orderBy('tanggal_mulai', 'desc')
                    ->get();

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
                // Jika tanggal selesai kosong, anggap cuma 1 hari
                'end' => $rec->tanggal_selesai ? $rec->tanggal_selesai->format('Y-m-d') : $rec->tanggal_mulai->format('Y-m-d'),
            ];
        })->toArray();

        return view('menstrual.index', compact(
            'records', 
            'indikasiAmenore', 
            'daysSinceLastPeriod', 
            'nextPeriodDate', 
            'daysRemaining', 
            'calendarEvents'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'tingkat_nyeri' => ['required', 'integer', 'min:1', 'max:5'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        // Paksa pakai ID siswa yang login (cegah IDOR)
        $validated['siswa_id'] = auth()->id();

        MenstrualRecord::create($validated);

        return redirect()->back()->with('success', 'Catatan siklus haid berhasil disimpan.');
    }
}