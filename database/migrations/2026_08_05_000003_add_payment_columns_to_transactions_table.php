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
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('payment_proof')->nullable();
                $table->string('payment_status')->default('menunggu_pembayaran');
                $table->timestamps();
            });
        } else {
            Schema::table('transactions', function (Blueprint $table) {
                if (!Schema::hasColumn('transactions', 'payment_proof')) {
                    $table->string('payment_proof')->nullable();
                }
                if (!Schema::hasColumn('transactions', 'payment_status')) {
                    $table->string('payment_status')->default('menunggu_pembayaran');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (Schema::hasColumn('transactions', 'payment_proof')) {
                    $table->dropColumn('payment_proof');
                }
                if (Schema::hasColumn('transactions', 'payment_status')) {
                    $table->dropColumn('payment_status');
                }
            });
        }
    }
};
