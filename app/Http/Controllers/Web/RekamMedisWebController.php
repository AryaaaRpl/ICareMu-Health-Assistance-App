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
        // TenantScope is automatically applied via BelongsToTenant trait if implemented on model,
        // or query using model default scope
        $rekam_medis = class_exists(RekamMedis::class) ? RekamMedis::with('siswa')->latest()->get() : collect();
        $siswas = class_exists(User::class) ? User::all() : collect();

        return view('rekam-medis.index', compact('rekam_medis', 'siswas'));
    }

    /**
     * Store a newly created medical record.
     */
    public function store(Request $request, IMTCalculatorService $imtService): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required'],
            'tinggi_badan' => ['required', 'numeric', 'min:1'],
            'berat_badan' => ['required', 'numeric', 'min:1'],
            'suhu' => ['required', 'numeric'],
            'tekanan_darah' => ['nullable', 'string', 'max:50'],
            'keluhan_utama' => ['required', 'string'],
            'penanganan' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        $tinggiBadan = (float) $validated['tinggi_badan'];
        $beratBadan = (float) $validated['berat_badan'];

        // Inject and use existing IMTCalculatorService
        $imtData = $imtService->calculate($beratBadan, $tinggiBadan);

        if (class_exists(RekamMedis::class)) {
            RekamMedis::create([
                'siswa_id' => $validated['siswa_id'],
                'tinggi_badan' => $tinggiBadan,
                'berat_badan' => $beratBadan,
                'suhu' => (float) $validated['suhu'],
                'tekanan_darah' => $validated['tekanan_darah'] ?? null,
                'keluhan_utama' => $validated['keluhan_utama'],
                'penanganan' => $validated['penanganan'] ?? null,
                'status' => $validated['status'],
                'imt_score' => $imtData['imt_score'],
                'status_risiko' => $imtData['status_risiko'],
                'tanggal' => now()->toDateString(),
            ]);
        }

        return redirect()->back()->with('success', 'Data Rekam Medis berhasil disimpan.');
    }
}
