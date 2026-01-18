<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Kolom Name langsung dibuat di sini
            $table->string('class_name');
            $table->date('date');
            $table->string('time');
            $table->text('notes')->nullable(); // Kolom Notes langsung dibuat di sini
            $table->timestamps();
            // Di dalam Schema::create('bookings'...)
 $table->string('status')->default('pending'); // Menambahkan status default pending
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};