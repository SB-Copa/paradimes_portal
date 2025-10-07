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
        Schema::create('model_has_user_event_reservations', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->unsignedBigInteger('event_reservation_id');

            $table->foreign('event_reservation_id')->references('id')->on('event_reservations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_user_event_reservations');
    }
};
