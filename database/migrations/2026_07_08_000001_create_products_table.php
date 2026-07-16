<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Catalog items (gym packages, store products, kitchen menu). Each row is
     * scoped to a `unit` and optionally linked to a category. Prices are stored
     * as whole Rupiah (no decimals).
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('unit');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->unsignedInteger('price')->default(0);
            $table->integer('stock')->default(0);
            $table->string('emoji')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
