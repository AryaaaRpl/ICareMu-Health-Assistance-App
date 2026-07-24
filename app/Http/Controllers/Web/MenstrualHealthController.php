<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MenstrualRecord;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenstrualHealthController extends Controller
{
    /**
     * Display student menstrual health tracking history, prediction & AI Amenorrhea check.
     */
    public function index(): View
    {
        $userId = auth()->id();

        $records = MenstrualRecord::where('siswa_id', $userId)
            ->latest('tanggal_mulai')
            ->get();

        $lastRecord = $records->first();

        $nextPeriodDate = null;
        $daysRemaining = null;
        $daysSinceLastPeriod = null;
        $indikasiAmenore = false;

        if ($lastRecord && $lastRecord->tanggal_mulai) {
            $lastStartDate = Carbon::parse($lastRecord->tanggal_mulai);
            $daysSinceLastPeriod = (int) $lastStartDate->diffInDays(now(), false);

            // Estimated next period date (28 days cycle)
            $nextPeriodDate = $lastStartDate->copy()->addDays(28);
            $daysRemaining = (int) ceil(now()->diffInDays($nextPeriodDate, false));

            // AI Early Warning Check: If gap since last period > 90 days -> Amenorrhea indication
            if ($daysSinceLastPeriod > 90) {
                $indikasiAmenore = true;
            }
        } else {
            // Default preview state
            $nextPeriodDate = now()->addDays(14);
            $daysRemaining = 14;
            $indikasiAmenore = false;
        }

        // Format dates array for dynamic Alpine.js calendar
        $calendarEvents = $records->map(function ($record) {
            return [
                'start' => $record->tanggal_mulai ? $record->tanggal_mulai->format('Y-m-d') : null,
                'end' => $record->tanggal_selesai ? $record->tanggal_selesai->format('Y-m-d') : ($record->tanggal_mulai ? $record->tanggal_mulai->format('Y-m-d') : null),
                'nyeri' => $record->tingkat_nyeri,
            ];
        })->filter(fn ($item) => !is_null($item['start']))->values();

        return view('menstrual.index', compact(
            'records',
            'lastRecord',
            'nextPeriodDate',
            'daysRemaining',
            'daysSinceLastPeriod',
            'indikasiAmenore',
            'calendarEvents'
        ));
    }

    /**
     * Store a newly logged menstrual cycle record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'tingkat_nyeri' => ['required', 'integer', 'min:1', 'max:5'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        MenstrualRecord::create([
            'siswa_id' => auth()->id(),
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'] ?? null,
            'tingkat_nyeri' => (int) $validated['tingkat_nyeri'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Catatan siklus haid berhasil disimpan.');
    }
}
