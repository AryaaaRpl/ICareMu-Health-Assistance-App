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
        Schema::table('peserta_skrining', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->after('catatan')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('peserta_skrining', function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_id');
        });
    }
};
