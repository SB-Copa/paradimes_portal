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
        Schema::create('venue_table_reservations', function (Blueprint $table) {
            $table->id();
            $table->uuid('venue_tables_reservation_unique_id');
            $table->unsignedBigInteger('venue_table_id');
            $table->unsignedBigInteger('venue_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('non_registered_user_id');
            $table->unsignedBigInteger('table_holder_type_id');

            $table->foreign('venue_table_id')->references('id')->on('venue_tables')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('table_holder_type_id')->references('id')->on('table_holder_types');
            $table->foreign('non_registered_user_id')->references('id')->on('non_registered_users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_tables_reservations');
    }
};
