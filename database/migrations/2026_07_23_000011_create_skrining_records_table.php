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
            $table->float('suhu_tubuh');
            $table->json('gejala')->nullable();
            $table->text('keluhan_tambahan')->nullable();
            $table->enum('ai_status', ['sehat', 'observasi_uks', 'pulang', 'darurat'])->nullable();
            $table->text('ai_recommendation')->nullable();
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
