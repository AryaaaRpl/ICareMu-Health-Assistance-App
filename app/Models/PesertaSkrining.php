<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaSkrining extends Model
{
    use HasFactory;

    protected $table = 'peserta_skrining';

    protected $fillable = [
        'sekolah_id',
        'jadwal_id',
        'siswa_id',
        'status_kehadiran',
        'catatan_hasil',
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jadwalSkrining(): BelongsTo
    {
        return $this->belongsTo(JadwalSkrining::class, 'jadwal_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
}
