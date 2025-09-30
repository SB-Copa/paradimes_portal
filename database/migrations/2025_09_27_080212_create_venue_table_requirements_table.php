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
        Schema::create('venue_table_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('venue_table_requirement_type_id');
            $table->unsignedBigInteger('venue_table_id');
            $table->integer('quantity');
            $table->decimal('price');

            $table->foreign('venue_table_id')->references('id')->on('venue_tables');
            $table->foreign('venue_table_requirement_type_id')->references('id')->on('venue_table_requirement_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_table_requirements');
    }
};
