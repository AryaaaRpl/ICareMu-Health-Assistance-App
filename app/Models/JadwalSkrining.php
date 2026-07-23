<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalSkrining extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'jadwal_skrining';

    protected $fillable = [
        'sekolah_id',
        'jenis_skrining',
        'nama_kegiatan',
        'tanggal_pelaksanaan',
        'tanggal',
        'lokasi',
        'status',
        'keterangan',
    ];

    /**
     * Get all participants for this screening schedule.
     */
    public function peserta(): HasMany
    {
        return $this->hasMany(PesertaSkrining::class, 'jadwal_id');
    }

    /**
     * Alias relationship to peserta for compatibility.
     */
    public function pesertaSkrining(): HasMany
    {
        return $this->hasMany(PesertaSkrining::class, 'jadwal_skrining_id');
    }
}
