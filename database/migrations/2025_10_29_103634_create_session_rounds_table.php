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
        Schema::create('session_rounds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('lap_time');

            $table->unsignedBigInteger('track_day_session_id');
            $table->foreign('track_day_session_id')->references('id')->on('track_day_sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_rounds');
    }
};
