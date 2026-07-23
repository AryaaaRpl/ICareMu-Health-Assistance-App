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
        Schema::create('siswa', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nisn');
            $table->date('tanggal_lahir');
            $table->string('nama_ortu');
            $table->string('no_wa_ortu');
            $table->string('golongan_darah');
            $table->timestamps();

            // Ensure NISN is unique within a school (tenant-aware uniqueness)
            $table->unique(['sekolah_id', 'nisn']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
