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
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('region_id');
            $table->string('province_id');
            $table->string('municipality_id');
            $table->string('barangay_id');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->json('websites')->nullable();
            $table->integer('capacity');
            $table->integer('user_count');
            $table->integer('table_count');
            $table->json('menu_images')->nullable();
            $table->json('banner_images')->nullable();
            $table->json('carousel_images')->nullable();
            $table->text('menu')->nullable();
            $table->text('about')->nullable();
            $table->unsignedBigInteger('venue_status_id');

            $table->foreign('venue_status_id')->references('id')->on('venue_statuses');
            
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
