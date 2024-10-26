<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coin_prices', function (Blueprint $table) {
            $table->id();
            $table->string('coin_id');
            $table->date('date');
            $table->string('quote');
            $table->decimal('price', 50, 8)->nullable();
            $table->decimal('volume_24h', 50, 8)->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->decimal('ath_price', 50, 8)->nullable();
            $table->timestamp('ath_date')->nullable();
            $table->timestamps();

            $table->foreign('coin_id')->references('id')->on('coins');
            $table->unique(['coin_id', 'date', 'quote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_prices');
    }
};
