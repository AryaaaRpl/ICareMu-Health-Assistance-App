<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Tenant\TenantContext;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarisUks extends Model
{
    use HasFactory;

    protected $table = 'inventaris_uks';

    protected $fillable = [
        'sekolah_id',
        'nama_barang',
        'kategori',
        'stok',
        'tanggal_kedaluwarsa',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (InventarisUks $item): void {
            if (!$item->sekolah_id && TenantContext::getTenantId()) {
                $item->sekolah_id = TenantContext::getTenantId();
            }
        });
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }
}
