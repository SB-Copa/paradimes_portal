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
        Schema::create('non_registered_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedBigInteger('suffix_id');
            $table->unsignedBigInteger('sex_id');
            $table->string('address')->nullable();
            $table->string('region_id');
            $table->string('province_id');
            $table->string('municipality_id');
            $table->string('barangay_id');
            $table->string('contact_number');
            $table->date('birthdate');
            $table->string('email')->unique();


            $table->foreign('suffix_id')->references('id')->on('suffix');
            $table->foreign('sex_id')->references('id')->on('sex');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('non_registered_users');
    }
};
