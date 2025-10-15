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
        Schema::create('event_reservation_ticket_guests', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_registered_guest_unique_id');
            $table->unsignedBigInteger('event_reservation_ticket_id');
            $table->string('full_name')->nullable();
            $table->integer('age')->nullable();
            $table->dateTime('entered_datetime')->nullable();


            $table->foreign('event_reservation_ticket_id')->references('id')->on('event_reservation_tickets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reservation_ticket_guests');
    }
};
