<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->integer('coins_spent');
            $table->timestamps();
            $table->unique(['content_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_purchases');
    }
};
