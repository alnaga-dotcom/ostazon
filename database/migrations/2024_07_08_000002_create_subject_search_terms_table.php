<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_search_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('term');
            $table->timestamps();
            $table->unique(['subject_id', 'term']);
            $table->index('term');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_search_terms');
    }
};
