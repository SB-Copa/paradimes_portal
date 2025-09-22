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
        Schema::create('model_has_social_media_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_media_platform_id');
            $table->morphs('model');

            $table->foreign('social_media_platform_id')->references('id')->on('social_media_platforms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_social_media_platforms');
    }
};
