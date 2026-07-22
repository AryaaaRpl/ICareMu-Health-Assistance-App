<?php

declare(strict_types=1);

namespace App\DTOs\Siswa;

readonly class CreateSiswaDTO
{
    public function __construct(
        public int $userId,
        public int $sekolahId,
        public string $namaLengkap,
        public string $nisn,
        public string $tanggalLahir,
        public ?string $namaOrtu = null,
        public ?string $noWaOrtu = null,
        public ?string $golonganDarah = null
    ) {}

    public static function fromRequest(array $data, int $sekolahId): self
    {
        return new self(
            userId: (int) $data['user_id'],
            sekolahId: $sekolahId,
            namaLengkap: $data['nama_lengkap'],
            nisn: $data['nisn'],
            tanggalLahir: $data['tanggal_lahir'],
            namaOrtu: $data['nama_ortu'] ?? null,
            noWaOrtu: $data['no_wa_ortu'] ?? null,
            golonganDarah: $data['golongan_darah'] ?? null
        );
    }
}
