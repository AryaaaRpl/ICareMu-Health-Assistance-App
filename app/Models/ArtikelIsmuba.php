<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtikelIsmuba extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'artikel_ismubas';

    protected $fillable = [
        'sekolah_id',
        'judul',
        'slug',
        'kategori',
        'konten',
        'thumbnail',
        'status',
    ];

    /**
     * Get the school (tenant) that owns the article.
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
