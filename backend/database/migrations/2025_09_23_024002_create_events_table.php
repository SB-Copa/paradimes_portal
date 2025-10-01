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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_unique_id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->text('about')->nullable();
            $table->boolean('is_recurring');
            $table->integer('capacity');
            $table->json('menu_images')->nullable();
            $table->json('banner_images')->nullable();
            $table->json('carousel_images')->nullable();


            $table->unsignedBigInteger('venue_id');
            $table->unsignedBigInteger('event_type_id');


        
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
