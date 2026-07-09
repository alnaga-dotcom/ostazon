<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'vodafone_cash', 'value' => '0100 000 0000'],
            ['key' => 'instapay', 'value' => 'ostazon@instapay.com'],
            ['key' => 'bank_name', 'value' => 'National Bank of Egypt'],
            ['key' => 'bank_account', 'value' => '123-456-789-0123456'],
            ['key' => 'paypal_email', 'value' => 'paypal@ostazon.com'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
