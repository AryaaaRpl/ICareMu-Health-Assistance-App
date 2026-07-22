<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sekolah_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nisn')->unique();
            $table->date('tanggal_lahir');
            $table->string('nama_ortu')->nullable();
            $table->string('no_wa_ortu')->nullable();
            $table->string('golongan_darah', 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
