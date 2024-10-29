<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('coin_prices', function (Blueprint $table) {
            $table->decimal('price_change_24h', 15, 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coin_prices', function (Blueprint $table) {
            $table->dropColumn('price_change_24h');
        });
    }
};
