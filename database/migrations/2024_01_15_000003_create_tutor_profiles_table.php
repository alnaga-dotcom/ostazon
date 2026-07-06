<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->decimal('hourly_rate', 10, 2)->default(0);
            $table->enum('lesson_mode', ['online', 'in_person', 'both'])->default('both');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('video_intro_url')->nullable();
            $table->string('id_document_url')->nullable();
            $table->string('certificate_url')->nullable();
            $table->enum('verification_status', ['pending', 'verified', 'certified', 'rejected'])->default('pending');
            $table->integer('total_lessons')->default(0);
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('available_balance', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_profiles');
    }
};
