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
        Schema::table('add_market_details', function (Blueprint $table) {
            $table->string('online')->default('online')->after('hash_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('add_market_details', function (Blueprint $table) {
            $table->dropColumn('online');
        });
    }
};
