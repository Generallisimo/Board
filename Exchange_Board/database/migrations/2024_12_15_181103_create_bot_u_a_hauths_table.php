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
        Schema::create('bot_u_a_hauths', function (Blueprint $table) {
            $table->id();
            $table->string('hash_id');
            $table->string('password');
            $table->string('role');
            $table->string('details_from');
            $table->string('details_to');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_u_a_hauths');
    }
};
