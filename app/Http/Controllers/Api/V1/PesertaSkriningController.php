<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Screening\StorePesertaSkriningRequest;
use App\Models\PesertaSkrining;
use Illuminate\Http\JsonResponse;

/**
 * Class PesertaSkriningController
 *
 * Handles API operations for recording student screening participants (Peserta Skrining).
 *
 * @package App\Http\Controllers\Api\V1
 */
class PesertaSkriningController extends Controller
{
    /**
     * Store a participant's screening result.
     * (sekolah_id is handled dynamically by BelongsToTenant trait)
     *
     * @param StorePesertaSkriningRequest $request
     * @return JsonResponse
     */
    public function store(StorePesertaSkriningRequest $request): JsonResponse
    {
        /** @var PesertaSkrining $participant */
        $participant = PesertaSkrining::create($request->validated());

        return response()->json([
            'message' => 'Screening participant result recorded successfully.',
            'data' => $participant,
        ], 201);
    }

    /**
     * Get all participants for a specific screening schedule with eager loaded student relations.
     *
     * @param int $jadwal_id
     * @return JsonResponse
     */
    public function getByJadwal(int $jadwal_id): JsonResponse
    {
        // Prevent N+1 queries by eager loading the 'siswa' relationship
        $participants = PesertaSkrining::with('siswa')
            ->where('jadwal_id', $jadwal_id)
            ->get();

        return response()->json([
            'message' => 'Screening participants retrieved successfully.',
            'data' => $participants,
        ], 200);
    }
}
