<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('peserta_skrining', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->constrained('jadwal_skrining')->cascadeOnDelete();
            $table->foreignId('jadwal_skrining_id')->nullable()->constrained('jadwal_skrining')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('status_kehadiran'); // e.g. Hadir, Tidak Hadir, Izin, Sakit
            $table->text('catatan_hasil')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_skrining');
    }
};
