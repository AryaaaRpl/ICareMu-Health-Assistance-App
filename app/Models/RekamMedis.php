<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'sekolah_id',
        'siswa_id',
        'keluhan_utama',
        'tinggi_badan',
        'berat_badan',
        'suhu',
        'tekanan_darah',
        'imt_score',
        'status_risiko',
        'status_penanganan',
        'status',
        'penanganan',
        'catatan_medis',
        'tanggal',
    ];

    /**
     * Get the student (user/siswa) associated with the medical record.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
