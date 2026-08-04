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
        Schema::create('rekam_medis', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_periksa')->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->decimal('tinggi_badan', 5, 2); // e.g. 175.50
            $table->decimal('berat_badan', 5, 2);  // e.g. 68.20
            $table->decimal('suhu', 4, 1)->nullable(); // e.g. 36.5
            $table->string('tekanan_darah')->nullable();
            $table->decimal('imt_score', 4, 2)->nullable(); // e.g. 22.15
            $table->string('status_risiko')->nullable(); // e.g. normal, underweight, overweight, obese
            $table->string('status_penanganan')->nullable();
            $table->string('status')->nullable();
            $table->text('penanganan')->nullable();
            $table->text('catatan_medis')->nullable();
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
        Schema::dropIfExists('rekam_medis');
    }
};
