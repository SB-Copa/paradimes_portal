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
        Schema::create('venue_table_reservation_guests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_table_reservation_id');
            $table->string('full_name');
            $table->integer('age');
            $table->dateTime('entered_datetime');
            $table->timestamps();

            $table->foreign('venue_table_reservation_id')->references('id')->on('venue_table_reservations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_table_registered_guests');
    }
};
