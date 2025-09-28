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
        Schema::create('event_reservation', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_reservation_unique_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('non_registered_user_id');
            
  
            $table->unsignedBigInteger('venue_table_reservation_id');
            $table->unsignedBigInteger('promotion_id');
            $table->unsignedBigInteger('payment_intent_id');
            $table->morphs('host_model');

            $table->foreign('non_registered_user_id')->references('id')->on('non_registered_user');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('venue_table_reservation_id')->references('id')->on('venue_table_reservation');
            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->foreign('payment_intent_id')->references('id')->on('payment_intent');
            



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reservation');
    }
};
