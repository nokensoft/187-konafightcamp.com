<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Payment / proof-of-transfer fields. A member (or staff) selects the
     * package they intend to buy and uploads a bank-transfer receipt; staff
     * then review the proof and verify the member to activate the membership.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('requested_package')->nullable()->after('verified_at');
            $table->string('payment_proof_path')->nullable()->after('requested_package');
            $table->timestamp('payment_submitted_at')->nullable()->after('payment_proof_path');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['requested_package', 'payment_proof_path', 'payment_submitted_at']);
        });
    }
};
