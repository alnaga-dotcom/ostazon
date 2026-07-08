<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('coin_wallets');
    }

    public function down()
    {
        // Recreate only if rolling back — not needed for normal operation
    }
};
