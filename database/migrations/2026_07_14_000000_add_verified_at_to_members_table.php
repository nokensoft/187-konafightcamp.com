<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a verification timestamp to members. Public self-registration leaves
     * this null (a "pending" registrant) until a manager/cashier verifies the
     * member from the POS. Existing rows are backfilled so current members stay
     * verified after the column is introduced.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable()->after('terms_accepted_at');
        });

        DB::statement('UPDATE members SET verified_at = created_at WHERE verified_at IS NULL');
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('verified_at');
        });
    }
};
