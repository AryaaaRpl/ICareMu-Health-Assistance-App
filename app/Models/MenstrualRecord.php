<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenstrualRecord extends Model
{
    use HasFactory;

    protected $table = 'menstrual_records';

    protected $fillable = [
        'siswa_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tingkat_nyeri',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tingkat_nyeri' => 'integer',
    ];

    /**
     * Get the student/user associated with the menstrual record.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
