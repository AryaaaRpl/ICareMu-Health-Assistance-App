<?php

declare(strict_types=1);

namespace App\DTOs\Medical;

readonly class CreateMedicalRecordDTO
{
    public function __construct(
        public int $siswaId,
        public int $sekolahId,
        public int $createdBy,
        public string $tanggalPeriksa,
        public float $tinggiBadan,
        public float $beratBadan,
        public ?string $catatanMedis = null
    ) {}

    public static function fromRequest(array $data, int $sekolahId, int $userId): self
    {
        return new self(
            siswaId: (int) $data['siswa_id'],
            sekolahId: $sekolahId,
            createdBy: $userId,
            tanggalPeriksa: $data['tanggal_periksa'],
            tinggiBadan: (float) $data['tinggi_badan'],
            beratBadan: (float) $data['berat_badan'],
            catatanMedis: $data['catatan_medis'] ?? null
        );
    }
}
