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
            $table->string('hash_id');
            $table->string('balance')->nullable();
            $table->string('details_from');
            $table->string('private_key');
            $table->string('details_to');
            $table->string('percent');
            $table->string('agent_id');


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
