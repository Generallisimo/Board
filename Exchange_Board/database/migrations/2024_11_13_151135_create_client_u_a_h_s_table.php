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
        Schema::create('client_u_a_h_s', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->string('fraud')->nullable();
            $table->string('balance')->nullable();
            $table->string('details_from');
            $table->string('api_key')->nullable();
            $table->string('private_key');
            $table->string('details_to');
            $table->string('percent');
            $table->timestamps();
            
            $table->foreign('hash_id')->references('hash_id')->on('users')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_u_a_h_s');
    }
};
