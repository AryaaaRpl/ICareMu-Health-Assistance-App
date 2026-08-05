<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'sekolah_id',
        'nama_lengkap',
        'nisn_nbm',
        'tanggal_lahir',
        'nama_ortu',
        'no_wa_ortu',
        'golongan_darah',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }
}
