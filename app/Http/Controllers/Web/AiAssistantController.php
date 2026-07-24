<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use App\Services\AiHealthAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AiAssistantController extends Controller
{
    /**
     * Display the AI Assistant chat interface.
     */
    public function index(): View
    {
        $rekamMedisList = class_exists(RekamMedis::class)
            ? RekamMedis::with('siswa')->latest()->get()
            : collect();

        return view('ai.index', compact('rekamMedisList'));
    }

    /**
     * Process interactive chat message via JSON API endpoint.
     */
    public function chat(Request $request, AiHealthAssistantService $aiService): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $reply = $aiService->analyzeText($validated['message']);

        return response()->json([
            'reply' => $reply,
        ]);
    }

    /**
     * Legacy analyze method for RekamMedis record selection.
     */
    public function analyze(Request $request, AiHealthAssistantService $aiService): RedirectResponse
    {
        $validated = $request->validate([
            'rekam_medis_id' => ['required'],
        ]);

        $record = RekamMedis::with('siswa')->find($validated['rekam_medis_id']);

        if (!$record) {
            return redirect()->route('ai.index')->with('error', 'Data Rekam Medis tidak ditemukan.');
        }

        $keluhan = $record->keluhan_utama ?? $record->catatan_medis ?? 'Demam dan pusing di ruang UKS';
        $suhu = $record->suhu ?? 37.0;
        $tekananDarah = $record->tekanan_darah ?? '120/80';
        $umur = 14;

        $result = $aiService->analyzeSymptom(
            keluhan: $keluhan,
            umur: $umur,
            suhu: $suhu,
            tekananDarah: $tekananDarah
        );

        return redirect()->route('ai.index')
            ->with('ai_result', $result)
            ->with('selected_record', $record);
    }
}
