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
        Schema::create('add_market_details', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->string('details_market_to');
            $table->string('name_method');
            $table->string('currency');
            $table->string('comment');
            
    
            
            $table->timestamps();
            
            $table->foreign('hash_id')->references('hash_id')->on('markets')->onDelete('cascade');
            $table->foreign('name_method')->references('name_method')->on('method_payments')->onDelete('cascade');
            $table->foreign('currency')->references('currency')->on('method_payments')->onDelete('cascade');
        
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_market_details');
    }
};
