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
        'siswa_id',
        'sekolah_id',
        'suhu_tubuh',
        'tekanan_darah',
        'keluhan',
        'status_kesehatan',
    ];

    protected $casts = [
        'suhu_tubuh' => 'float',
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
