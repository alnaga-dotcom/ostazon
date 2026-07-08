<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('lesson_status');
            }
            if (!Schema::hasColumn('bookings', 'frozen_until')) {
                $table->timestamp('frozen_until')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('bookings', 'arbitration_fee_paid')) {
                $table->boolean('arbitration_fee_paid')->default(false)->after('frozen_until');
            }
            if (!Schema::hasColumn('bookings', 'arbitration_fee_amount')) {
                $table->decimal('arbitration_fee_amount', 10, 2)->nullable()->after('arbitration_fee_paid');
            }
            if (!Schema::hasColumn('bookings', 'arbitration_status')) {
                $table->string('arbitration_status')->default('none')->after('arbitration_fee_amount');
            }
            if (!Schema::hasColumn('bookings', 'arbitration_evidence')) {
                $table->text('arbitration_evidence')->nullable()->after('arbitration_status');
            }
            if (!Schema::hasColumn('bookings', 'claimant_type')) {
                $table->string('claimant_type')->nullable()->after('arbitration_evidence');
            }
            if (!Schema::hasColumn('bookings', 'disputed_at')) {
                $table->timestamp('disputed_at')->nullable()->after('claimant_type');
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columns = ['completed_at', 'frozen_until', 'arbitration_fee_paid', 'arbitration_fee_amount', 'arbitration_status', 'arbitration_evidence', 'claimant_type', 'disputed_at'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('bookings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
