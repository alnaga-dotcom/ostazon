<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->timestamp('frozen_until')->nullable()->after('completed_at');
            $table->boolean('arbitration_fee_paid')->default(false)->after('frozen_until');
            $table->enum('claimant_type', ['student', 'tutor', 'none'])->default('none')->after('arbitration_fee_paid');
            $table->timestamp('disputed_at')->nullable()->after('claimant_type');
            $table->text('dispute_reason')->nullable()->after('disputed_at');
            $table->enum('arbitration_status', ['none', 'pending', 'resolved_student', 'resolved_tutor', 'rejected'])->default('none')->after('dispute_reason');
            $table->decimal('arbitration_fee_amount', 10, 2)->default(0)->after('arbitration_status');
            $table->text('arbitration_evidence')->nullable()->after('arbitration_fee_amount');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'frozen_until',
                'arbitration_fee_paid',
                'claimant_type',
                'disputed_at',
                'dispute_reason',
                'arbitration_status',
                'arbitration_fee_amount',
                'arbitration_evidence',
            ]);
        });
    }
};
