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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('municipality_id');
            $table->unsignedBigInteger('barangay_id');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->json('websites')->nullable();
            $table->integer('capacity');
            $table->integer('user_count');
            $table->integer('table_count');
            $table->json('menu_images');
            $table->json('banner_images');
            $table->json('carousel_images');
            $table->text('menu');
            $table->text('about');
            $table->unsignedBigInteger('venue_status_id');

            $table->foreign('venue_status_id')->references('id')->on('venue_status');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
