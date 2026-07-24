<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkriningRecord extends Model
{
    use HasFactory;

    protected $table = 'skrining_records';

    protected $fillable = [
        'sekolah_id',
        'siswa_id',
        'suhu_tubuh',
        'gejala',
        'keluhan_tambahan',
        'ai_status',
        'ai_recommendation',
        'tindakan_uks',
        'obat_diberikan',
        'waktu_ditindak',
        'status_akhir',
    ];

    protected $casts = [
        'suhu_tubuh' => 'float',
        'gejala' => 'array',
        'waktu_ditindak' => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
