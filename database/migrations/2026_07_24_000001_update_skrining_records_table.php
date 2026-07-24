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
            // Drop old/incorrect columns if present
            if (Schema::hasColumn('skrining_records', 'tekanan_darah')) {
                $table->dropColumn('tekanan_darah');
            }
            if (Schema::hasColumn('skrining_records', 'keluhan')) {
                $table->dropColumn('keluhan');
            }
            if (Schema::hasColumn('skrining_records', 'status_kesehatan')) {
                $table->dropColumn('status_kesehatan');
            }

            // Add missing columns if they don't exist yet
            if (!Schema::hasColumn('skrining_records', 'gejala')) {
                $table->json('gejala')->nullable()->after('suhu_tubuh');
            }
            if (!Schema::hasColumn('skrining_records', 'keluhan_tambahan')) {
                $table->text('keluhan_tambahan')->nullable()->after('gejala');
            }
            if (!Schema::hasColumn('skrining_records', 'ai_status')) {
                $table->enum('ai_status', ['sehat', 'observasi_uks', 'pulang', 'darurat'])->nullable()->after('keluhan_tambahan');
            }
            if (!Schema::hasColumn('skrining_records', 'ai_recommendation')) {
                $table->text('ai_recommendation')->nullable()->after('ai_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrining_records', function (Blueprint $table) {
            $table->string('tekanan_darah')->nullable();
            $table->text('keluhan')->nullable();
            $table->enum('status_kesehatan', ['sehat', 'sakit_ringan', 'butuh_penanganan'])->default('sehat');

            $table->dropColumn(['gejala', 'keluhan_tambahan', 'ai_status', 'ai_recommendation']);
        });
    }
};
