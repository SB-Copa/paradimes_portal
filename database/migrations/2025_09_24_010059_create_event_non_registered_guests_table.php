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
        Schema::create('event_non_registered_guests', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_non_registered_guest_unique_key');
            $table->unsignedBigInteger('event_reservation_ticket_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedBigInteger('suffix_id')->nullable();
            $table->unsignedBigInteger('sex_id');
            $table->string('address')->nullable();
            $table->string('region_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('municipality_id')->nullable();
            $table->string('barangay_id')->nullable();
            $table->string('email');
            $table->string('contact_number');
            $table->date('birthdate');

            $table->foreign('suffix_id')->references('id')->on('suffix');
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->foreign('event_reservation_ticket_id')->references('id')->on('event_reservation_tickets');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_non_registered_guests');
    }
};
