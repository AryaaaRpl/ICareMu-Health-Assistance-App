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
        Schema::table('skrining_records', function (Blueprint $table) {
            if (!Schema::hasColumn('skrining_records', 'sekolah_id')) {
                $table->foreignId('sekolah_id')->nullable()->after('siswa_id')->constrained('sekolahs')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrining_records', function (Blueprint $table) {
            if (Schema::hasColumn('skrining_records', 'sekolah_id')) {
                $table->dropForeign(['sekolah_id']);
                $table->dropColumn('sekolah_id');
            }
        });
    }
};
