<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('artikel_ismubas');

        Schema::create('artikel_ismubas', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', [
                'edukasi_kesehatan',
                'fikih_wanita',
                'kesehatan_mental',
                'artikel_islami',
            ]);
            $table->longText('konten');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel_ismubas');
    }
};
