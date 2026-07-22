<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Tenant\TenantContext;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'siswa_id',
        'sekolah_id',
        'created_by',
        'tanggal_periksa',
        'tinggi_badan',
        'berat_badan',
        'imt_score',
        'status_risiko',
        'catatan_medis',
        'status_verifikasi',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (RekamMedis $rekamMedis): void {
            if (!$rekamMedis->sekolah_id && TenantContext::getTenantId()) {
                $rekamMedis->sekolah_id = TenantContext::getTenantId();
            }
        });
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
