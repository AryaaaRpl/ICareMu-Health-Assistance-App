<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisUks extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'inventaris_uks';

    protected $fillable = [
        'sekolah_id',
        'nama_barang',
        'kategori',
        'jumlah',
        'stok',
        'satuan',
        'kondisi',
        'keterangan',
    ];
}
