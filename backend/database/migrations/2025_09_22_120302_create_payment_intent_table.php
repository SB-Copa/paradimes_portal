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
        Schema::create('payment_intent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_reservation_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->decimal('total_amount');
            $table->unsignedBigInteger('curreny_id');
            $table->string('statement_descriptor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_intent');
    }
};
