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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_id');
            $table->string('user_id');
            $table->string('user_role');
            // $table->string('transaction_id');
            // $table->string('owner_address');
            // $table->string('address_to');
            $table->string('amount');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exchange_id')->references('exchange_id')->on('exchanges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
