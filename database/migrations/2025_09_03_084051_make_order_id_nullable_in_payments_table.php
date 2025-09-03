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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Eğer isterseniz, bu komutla order_id'yi tekrar NOT NULL yapabilirsiniz.
            // Ancak bu, NULL olan kayıtlar varsa hata verebilir.
            $table->unsignedBigInteger('order_id')->nullable(false)->change();
        });
    }
};
