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
        Schema::create('event_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_reservation_unique_id');
            $table->unsignedBigInteger('event_id');
            $table->morphs('model');
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->boolean('is_primary');
            // $table->unsignedBigInteger('payment_intent_id');
            // $table->unsignedBigInteger('venue_table_reservation_id');


            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            // $table->foreign('venue_table_reservation_id')->references('id')->on('venue_table_reservations');
            // $table->foreign('promotion_id')->references('id')->on('promotions');
            // $table->foreign('payment_intent_id')->references('id')->on('payment_intents');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reservations');
    }
};
