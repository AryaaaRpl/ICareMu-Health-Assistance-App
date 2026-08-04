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
            if (!Schema::hasColumn('skrining_records', 'tindakan_uks')) {
                $table->text('tindakan_uks')->nullable()->after('ai_recommendation');
            }
            if (!Schema::hasColumn('skrining_records', 'obat_diberikan')) {
                $table->string('obat_diberikan')->nullable()->after('tindakan_uks');
            }
            if (!Schema::hasColumn('skrining_records', 'waktu_ditindak')) {
                $table->timestamp('waktu_ditindak')->nullable()->after('obat_diberikan');
            }
            if (!Schema::hasColumn('skrining_records', 'status_akhir')) {
                $table->enum('status_akhir', ['kembali_ke_kelas', 'istirahat_di_uks', 'pulang', 'rujuk_rs'])->nullable()->after('waktu_ditindak');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrining_records', function (Blueprint $table) {
            $table->dropColumn(['tindakan_uks', 'obat_diberikan', 'waktu_ditindak', 'status_akhir']);
        });
    }
};
