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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('percentage');
            $table->decimal('value');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('promotion_type_id');
            $table->integer('usage_limit');

            $table->foreign('promotion_type_id')->references('id')->on('promotion_type');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
