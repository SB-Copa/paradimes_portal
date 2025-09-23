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
            $table->string('name');
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('about')->nullable();
            $table->boolean('is_recurring');
            $table->integer('capacity');
            $table->json('menu_images');
            $table->json('banner_images');
            $table->json('carousel_images');

      
            $table->unsignedBigInteger('marketing_company_id');
            $table->unsignedBigInteger('venue_id');
            $table->unsignedBigInteger('event_type_id');
            $table->unsignedBigInteger('event_ticket_type_id');

            $table->foreign('marketing_company_id')->references('id')->on('marketing_company')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venue')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_type');
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
