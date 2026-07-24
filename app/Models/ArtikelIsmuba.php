<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtikelIsmuba extends Model
{
    use HasFactory;

    protected $table = 'artikel_ismubas';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'kategori',
        'image_url',
    ];
}
