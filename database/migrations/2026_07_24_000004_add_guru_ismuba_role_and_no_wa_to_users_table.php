<?php

declare(strict_types=1);

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
        Schema::table('users', static function (Blueprint $table): void {
            if (!Schema::hasColumn('users', 'no_wa')) {
                $table->string('no_wa')->nullable()->after('email');
            }
        });

        // Modify enum role if on MySQL/MariaDB
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin_uks', 'petugas_uks', 'admin_super', 'siswa', 'guru_ismuba') DEFAULT 'siswa'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'no_wa')) {
                $table->dropColumn('no_wa');
            }
        });
    }
};
