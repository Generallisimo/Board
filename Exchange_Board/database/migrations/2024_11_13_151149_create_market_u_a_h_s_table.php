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
        Schema::create('market_u_a_h_s', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->string('status');
            $table->string('balance')->nullable();
            $table->string('details_from');
            $table->string('private_key');
            $table->string('details_to');
            $table->string('percent');
            $table->string('agent_id');


            $table->timestamps();
            
            $table->foreign('hash_id')->references('hash_id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('hash_id')->on('agent_u_a_h_s')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_u_a_h_s');
    }
};
