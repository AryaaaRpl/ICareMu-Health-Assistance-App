<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolahs';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'sekolah_id');
    }
}
