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
        Schema::create('venue_table_reservation', function (Blueprint $table) {
            $table->id();
            $table->uuid('venue_table_reservation_unique_id');
            $table->unsignedBigInteger('venue_table_id');
            $table->unsignedBigInteger('venue_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reservation_holder_type_id');

            $table->foreign('venue_table_id')->references('id')->on('venue_table')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venue')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('reservation_holder_type_id')->references('id')->on('reservation_holder_type_reservation');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_table_reservation');
    }
};
