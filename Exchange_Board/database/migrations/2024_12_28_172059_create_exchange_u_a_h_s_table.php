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
        Schema::create('exchange_u_a_h_s', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_id');
            $table->string('market_id');
            $table->string('market_percent');
            $table->string('market_amount')->nullable();
            $table->string('market_details_from');
            $table->string('agent_id');
            $table->string('agent_percent');
            $table->string('agent_amount')->nullable();
            $table->string('agent_details_from');
            $table->string('client_id')->nullable();
            $table->string('client_percent')->nullable();
            $table->string('client_amount')->nullable();
            $table->string('amount_USDT')->nullable();
            $table->string('amount_UAH');
            $table->string('price_UAH');
            $table->string('client_details_from')->nullable();
            $table->string('add_details_client')->nullable();
            $table->string('add_method_client')->nullable();
            $table->string('result');
            $table->string('message');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_u_a_h_s');
    }
};
