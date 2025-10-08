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
        Schema::create('venue_table_non_registered_guests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedBigInteger('suffix_id')->nullable();
            $table->date('birthdate');
            $table->unsignedBigInteger('sex_id')->nullable();
            // $table->unsignedBigInteger('venue_table_reservation_id');

            
            // $table->foreign('venue_table_reservation_id')->references('id')->on('venue_table_reservations');
            $table->foreign('suffix_id')->references('id')->on('suffix');
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_table_non_registered_guests');
    }
};
