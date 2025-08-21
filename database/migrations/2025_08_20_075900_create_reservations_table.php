<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Guest kullanıcılar için nullable
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
            $table->dateTime('datetime');
            $table->dateTime('end_datetime');
            $table->integer('people');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'reserved', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->boolean('is_preorder')->default(false);
            $table->string('preorder_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};
