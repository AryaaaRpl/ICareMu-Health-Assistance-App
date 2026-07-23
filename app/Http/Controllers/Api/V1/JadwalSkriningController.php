<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Screening\StoreJadwalRequest;
use App\Models\JadwalSkrining;
use Illuminate\Http\JsonResponse;

/**
 * Class JadwalSkriningController
 *
 * Handles API requests related to screening schedules (Jadwal Skrining) with tenant isolation.
 *
 * @package App\Http\Controllers\Api\V1
 */
class JadwalSkriningController extends Controller
{
    /**
     * Display a listing of the screening schedules.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $schedules = JadwalSkrining::all();

        return response()->json([
            'message' => 'Screening schedules retrieved successfully.',
            'data' => $schedules,
        ], 200);
    }

    /**
     * Store a newly created screening schedule.
     * (sekolah_id is handled dynamically by BelongsToTenant trait)
     *
     * @param StoreJadwalRequest $request
     * @return JsonResponse
     */
    public function store(StoreJadwalRequest $request): JsonResponse
    {
        /** @var JadwalSkrining $schedule */
        $schedule = JadwalSkrining::create($request->validated());

        return response()->json([
            'message' => 'Screening schedule created successfully.',
            'data' => $schedule,
        ], 201);
    }
}
