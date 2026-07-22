<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_konsultasi';

    protected $fillable = [
        'sekolah_id',
        'siswa_id',
        'jenis_konsultasi',
        'isi_pertanyaan',
        'jawaban',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
