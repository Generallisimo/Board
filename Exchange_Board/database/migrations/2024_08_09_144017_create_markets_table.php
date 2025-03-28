<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id')->unique();
            $table->decimal('balance', 18, 8)->nullable();
            $table->decimal('balance_hold', 18, 8)->nullable();
            $table->string('details_from');
            $table->string('private_key');
            $table->string('details_to');
            $table->string('percent');
            $table->string('agent_id');
            $table->string('api_key');


            $table->timestamps();
            
            $table->foreign('hash_id')->references('hash_id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('hash_id')->on('agents')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};
