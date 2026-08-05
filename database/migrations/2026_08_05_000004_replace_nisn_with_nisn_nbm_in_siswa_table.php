<?php

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
        if (Schema::hasTable('siswa') && Schema::hasColumn('siswa', 'nisn') && !Schema::hasColumn('siswa', 'nisn_nbm')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->renameColumn('nisn', 'nisn_nbm');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('siswa') && Schema::hasColumn('siswa', 'nisn_nbm')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->renameColumn('nisn_nbm', 'nisn');
            });
        }
    }
};
