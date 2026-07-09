<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        Schema::table('tutor_subjects', function (Blueprint $table) {
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tutor_subjects', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropColumn('level_id');
        });

        Schema::dropIfExists('levels');
    }
};
