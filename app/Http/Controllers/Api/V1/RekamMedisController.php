<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Medical\CalculateImtAction;
use App\Core\Tenant\TenantContext;
use App\DTOs\Medical\CreateMedicalRecordDTO;
use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index(): JsonResponse
    {
        $records = RekamMedis::with('siswa')->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Data rekam medis berhasil diambil',
            'data' => $records->items(),
            'meta' => [
                'current_page' => $records->currentPage(),
                'last_page' => $records->lastPage(),
                'per_page' => $records->perPage(),
                'total' => $records->total(),
                'version' => 'v1',
            ],
        ]);
    }

    public function store(Request $request, CalculateImtAction $calculateImt): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_periksa' => 'required|date',
            'tinggi_badan' => 'required|numeric|min:30|max:250',
            'berat_badan' => 'required|numeric|min:2|max:300',
            'catatan_medis' => 'nullable|string',
        ]);

        $sekolahId = TenantContext::getTenantId();
        if (!$sekolahId) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant context missing.',
                'errors' => ['tenant' => ['Sekolah ID is required']],
            ], 422);
        }

        $dto = CreateMedicalRecordDTO::fromRequest($validated, $sekolahId, (int) $request->user()->id);

        $calculation = $calculateImt->execute($dto->tinggiBadan, $dto->beratBadan);

        $rekamMedis = RekamMedis::create([
            'siswa_id' => $dto->siswaId,
            'sekolah_id' => $dto->sekolahId,
            'created_by' => $dto->createdBy,
            'tanggal_periksa' => $dto->tanggalPeriksa,
            'tinggi_badan' => $dto->tinggiBadan,
            'berat_badan' => $dto->beratBadan,
            'imt_score' => $calculation['imt'],
            'status_risiko' => $calculation['status_risiko'],
            'catatan_medis' => $dto->catatanMedis,
            'status_verifikasi' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil dibuat',
            'data' => $rekamMedis,
            'meta' => ['version' => 'v1'],
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $record = RekamMedis::with(['siswa', 'creator'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail rekam medis berhasil diambil',
            'data' => $record,
            'meta' => ['version' => 'v1'],
        ]);
    }

    public function verify(int $id, Request $request): JsonResponse
    {
        $record = RekamMedis::findOrFail($id);

        // Verification business logic
        $record->update([
            'status_verifikasi' => 'verified',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil diverifikasi oleh dokter',
            'data' => $record,
            'meta' => ['version' => 'v1'],
        ]);
    }
}
