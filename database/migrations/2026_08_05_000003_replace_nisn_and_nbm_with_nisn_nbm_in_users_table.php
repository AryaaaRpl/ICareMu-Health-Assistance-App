<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename nisn to nisn_nbm if nisn exists
        if (Schema::hasColumn('users', 'nisn') && !Schema::hasColumn('users', 'nisn_nbm')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('nisn', 'nisn_nbm');
            });
        }

        // 2. If nbm exists, copy nbm values over to nisn_nbm where nisn_nbm is null, then drop nbm column
        if (Schema::hasColumn('users', 'nbm')) {
            if (Schema::hasColumn('users', 'nisn_nbm')) {
                DB::statement("UPDATE users SET nisn_nbm = nbm WHERE (nisn_nbm IS NULL OR nisn_nbm = '') AND nbm IS NOT NULL AND nbm != ''");
            }
            Schema::table('users', function (Blueprint $table) {
                // Drop index if exists to avoid SQLite in-memory migration error
                try {
                    $table->dropUnique('users_nbm_unique');
                } catch (\Throwable $e) {
                    // Ignore if index does not exist
                }
                $table->dropColumn('nbm');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('users', 'nbm')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('nbm', 20)->nullable();
            });
        }

        if (Schema::hasColumn('users', 'nisn_nbm')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('nisn_nbm', 'nisn');
            });
        }
    }
};
