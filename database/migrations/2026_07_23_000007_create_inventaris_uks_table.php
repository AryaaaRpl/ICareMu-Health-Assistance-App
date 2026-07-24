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
        Schema::create('inventaris_uks', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolahs')->cascadeOnDelete();
            $table->string('nama_barang');
            $table->string('kategori'); // e.g. Obat, Alat Medis, Logistik
            $table->integer('jumlah')->default(0);
            $table->integer('stok')->default(0);
            $table->string('satuan')->nullable(); // e.g. Strip, Botol, Unit, Box
            $table->string('kondisi')->default('Baik'); // e.g. Baik, Rusak
            $table->text('keterangan')->nullable();
            $table->date('tanggal_kedaluwarsa')->nullable();
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
        Schema::dropIfExists('inventaris_uks');
    }
};
