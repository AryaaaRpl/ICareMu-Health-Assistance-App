<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaSkrining extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'peserta_skrining';

    protected $fillable = [
        'sekolah_id',
        'jadwal_id',
        'jadwal_skrining_id',
        'siswa_id',
        'status_kehadiran',
        'catatan_hasil',
        'catatan',
    ];

    /**
     * Get the screening schedule associated with the participant.
     */
    public function jadwalSkrining(): BelongsTo
    {
        return $this->belongsTo(JadwalSkrining::class, 'jadwal_id');
    }

    /**
     * Get the student associated with the screening result.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
