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
        Schema::create('track_day_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->unsignedBigInteger('track_day_id');
            $table->foreign('track_day_id')->references('id')->on('track_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_day_sessions');
    }
};
