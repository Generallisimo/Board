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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_id')->unique();
            $table->string('method')->nullable();
            $table->string('currency')->nullable();
            $table->string('client_id');
            $table->string('market_id');
            $table->string('market_api_key');
            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('amount_users', 18, 8)->nullable();            
            $table->string('result')->nullable()->default('await');
            $table->string('message')->nullable();
            $table->decimal('percent_client', 18, 8)->nullable();
            $table->decimal('amount_client', 18, 8)->nullable();
            $table->decimal('percent_market', 18, 8)->nullable();
            $table->decimal('amount_market', 18, 8)->nullable();
            $table->decimal('percent_agent', 18, 8)->nullable();
            $table->decimal('amount_agent', 18, 8)->nullable();
            $table->string('details_market_payment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
