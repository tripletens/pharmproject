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
        Schema::table('prescription', function (Blueprint $table) {
            //
            $table->time('daily_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription', function (Blueprint $table) {
            //
            $table->dropColumn('daily_time');
        });
    }
};
