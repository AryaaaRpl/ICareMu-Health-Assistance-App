<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\StoreKesehatanReproduksiRequest;
use App\Models\KesehatanReproduksi;
use Illuminate\Http\JsonResponse;

/**
 * Class KesehatanReproduksiController
 *
 * API Controller managing reproductive/menstrual health records with tenant isolation.
 *
 * @package App\Http\Controllers\Api\V1
 */
class KesehatanReproduksiController extends Controller
{
    /**
     * Display reproductive health records for the tenant.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $records = KesehatanReproduksi::all();

        return response()->json([
            'message' => 'Reproductive health records retrieved successfully.',
            'data' => $records,
        ], 200);
    }

    /**
     * Store a reproductive health record.
     * (sekolah_id is handled dynamically by BelongsToTenant trait)
     *
     * @param StoreKesehatanReproduksiRequest $request
     * @return JsonResponse
     */
    public function store(StoreKesehatanReproduksiRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // status_ai_amenore starts as 'pending' before processing by the AI engine.
        /** @var KesehatanReproduksi $record */
        $record = KesehatanReproduksi::create([
            'siswa_id' => $validated['siswa_id'],
            'tanggal_haid' => $validated['tanggal_haid'],
            'status_ai_amenore' => 'pending',
        ]);

        return response()->json([
            'message' => 'Reproductive health record created successfully.',
            'data' => $record,
        ], 201);
    }
}
