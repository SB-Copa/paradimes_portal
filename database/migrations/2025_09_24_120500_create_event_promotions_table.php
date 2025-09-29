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
        Schema::create('event_promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('percentage');
            $table->decimal('value');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedBigInteger('promotion_type_id');
            $table->integer('usage_limit');
            $table->unsignedBigInteger('event_id');

            $table->foreign('promotion_type_id')->references('id')->on('event_promotion_types');
            $table->foreign('event_id')->references('id')->on('events');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_promotions');
    }
};
