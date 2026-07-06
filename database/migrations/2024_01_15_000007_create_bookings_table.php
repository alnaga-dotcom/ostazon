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
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->enum('booking_type', ['direct', 'request'])->default('direct');
            $table->enum('lesson_mode', ['online', 'in_person'])->default('online');
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(60);
            $table->decimal('lesson_fee', 10, 2)->default(0);
            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->decimal('tutor_earnings', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'escrow', 'released', 'refunded', 'off_platform'])->default('pending');
            $table->enum('lesson_status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->boolean('platform_guarantee')->default(false);
            $table->text('student_notes')->nullable();
            $table->text('tutor_notes')->nullable();
            $table->dateTime('dispute_until')->nullable();
            $table->boolean('dispute_filed')->default(false);
            $table->text('dispute_reason')->nullable();
            $table->dateTime('dispute_resolved_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
