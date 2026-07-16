<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Per-product discount: `discount_type` is null (no discount), 'percent'
     * (a percentage off) or 'amount' (a flat Rupiah amount off). `discount_value`
     * holds the percentage (0-100) or the Rupiah amount depending on the type.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('discount_type')->nullable()->after('price');
            $table->unsignedInteger('discount_value')->default(0)->after('discount_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'discount_value']);
        });
    }
};
