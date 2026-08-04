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
        Schema::table('artikel_ismubas', function (Blueprint $table) {
            if (Schema::hasColumn('artikel_ismubas', 'kategori')) {
                $table->string('kategori', 100)->default('Fiqih')->change();
            } else {
                $table->string('kategori', 100)->default('Fiqih')->after('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikel_ismubas', function (Blueprint $table) {
            //
        });
    }
};
