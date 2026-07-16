<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Soft deletes so staff can move a member to the Trash and restore them,
     * backing the POS recycle-bin with real persistence.
     */
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
