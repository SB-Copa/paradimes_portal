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
        Schema::create('event_available_ticket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_ticket_type_id');
            $table->integer('available_tickets');

            $table->foreign('event_ticket_type_id')->references('id')->on('event_ticket_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_available_ticket');
    }
};
