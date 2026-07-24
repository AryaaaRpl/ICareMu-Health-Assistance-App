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
        Schema::create('skrining_records', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sekolah_id')->nullable()->constrained('sekolahs')->nullOnDelete();
            $table->float('suhu_tubuh')->default(36.5);
            $table->string('tekanan_darah')->nullable();
            $table->text('keluhan')->nullable();
            $table->enum('status_kesehatan', ['sehat', 'sakit_ringan', 'butuh_penanganan'])->default('sehat');
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
        Schema::dropIfExists('skrining_records');
    }
};
