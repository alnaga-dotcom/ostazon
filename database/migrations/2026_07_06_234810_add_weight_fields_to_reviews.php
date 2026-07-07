<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_verified_booking')->default(true)->after('is_public');
            $table->text('tutor_reply')->nullable()->after('comment');
            $table->integer('helpful_count')->default(0)->after('tutor_reply');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_verified_booking', 'tutor_reply', 'helpful_count']);
        });
    }
};