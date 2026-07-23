<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\StoreRekamMedisRequest;
use App\Models\RekamMedis;
use App\Services\Health\IMTCalculatorService;
use Illuminate\Http\JsonResponse;

/**
 * Class RekamMedisController
 *
 * API Controller managing student medical records (Rekam Medis) with tenant isolation.
 *
 * @package App\Http\Controllers\Api\V1
 */
class RekamMedisController extends Controller
{
    /**
     * Display a list of the tenant's medical records.
     * (Automatic scoping is handled by the TenantScope via BelongsToTenant trait)
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $records = RekamMedis::all();

        return response()->json([
            'message' => 'Medical records retrieved successfully.',
            'data' => $records,
        ], 200);
    }

    /**
     * Store a newly created medical record.
     * Uses IMTCalculatorService to calculate the IMT score and status_risiko.
     *
     * @param StoreRekamMedisRequest $request
     * @param IMTCalculatorService $imtService
     * @return JsonResponse
     */
    public function store(StoreRekamMedisRequest $request, IMTCalculatorService $imtService): JsonResponse
    {
        $validated = $request->validated();

        $tinggiBadan = (float) $validated['tinggi_badan'];
        $beratBadan = (float) $validated['berat_badan'];

        // Perform Kemenkes-compliant IMT calculation
        $imtData = $imtService->calculate($beratBadan, $tinggiBadan);

        // create_by is linked to the authenticated user, while sekolah_id
        // is auto-injected by the creating hook in the BelongsToTenant trait.
        /** @var RekamMedis $record */
        $record = RekamMedis::create([
            'siswa_id' => $validated['siswa_id'],
            'tanggal_periksa' => $validated['tanggal_periksa'],
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'imt_score' => $imtData['imt_score'],
            'status_risiko' => $imtData['status_risiko'],
            'catatan_medis' => $validated['catatan_medis'] ?? null,
            'created_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Medical record created successfully.',
            'data' => $record,
        ], 201);
    }
}
