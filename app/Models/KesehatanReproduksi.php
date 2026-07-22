<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KesehatanReproduksi extends Model
{
    use HasFactory;

    protected $table = 'kesehatan_reproduksis';

    protected $fillable = [
        'siswa_id',
        'sekolah_id',
        'tanggal_haid',
        'status_ai_amenore',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }
}
