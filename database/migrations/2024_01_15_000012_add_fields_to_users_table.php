<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['student', 'tutor', 'admin'])->default('student')->after('phone');
            $table->string('referral_code', 10)->unique()->nullable()->after('role');
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null')->after('referral_code');
            $table->boolean('is_active')->default(true)->after('referred_by');
            $table->dateTime('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'referral_code', 'referred_by', 'is_active', 'last_login_at']);
        });
    }
};
