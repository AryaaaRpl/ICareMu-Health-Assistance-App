<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSkrining extends Model
{
    use HasFactory;

    protected $table = 'jadwal_skrining';
    protected $fillable = ['sekolah_id', 'jenis_skrining', 'tanggal_pelaksanaan', 'lokasi', 'status'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
