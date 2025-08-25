<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('carts');
    }
};
