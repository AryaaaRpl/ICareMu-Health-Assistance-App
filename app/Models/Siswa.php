<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Tenant\TenantContext;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sekolah_id',
        'nama_lengkap',
        'nisn',
        'tanggal_lahir',
        'nama_ortu',
        'no_wa_ortu',
        'golongan_darah',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (Siswa $siswa): void {
            if (!$siswa->sekolah_id && TenantContext::getTenantId()) {
                $siswa->sekolah_id = TenantContext::getTenantId();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function rekamMedis(): HasMany
    {
        return $this->hasMany(RekamMedis::class);
    }

    public function kesehatanReproduksi(): HasMany
    {
        return $this->hasMany(KesehatanReproduksi::class);
    }

    public function pesertaSkrining(): HasMany
    {
        return $this->hasMany(PesertaSkrining::class);
    }

    public function riwayatKonsultasi(): HasMany
    {
        return $this->hasMany(RiwayatKonsultasi::class);
    }
}
