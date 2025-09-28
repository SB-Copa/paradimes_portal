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
        Schema::create('hosts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedBigInteger('suffix_id')->nullable();
            $table->unsignedBigInteger('sex_id');
            $table->unsignedBigInteger('regCode');
            $table->unsignedBigInteger('provCode');
            $table->unsignedBigInteger('citymunCode');
            $table->unsignedBigInteger('brgyCode');
            $table->string('contact_number');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreign('sex_id')->references('id')->on('sex');
            $table->foreign('suffix_id')->references('id')->on('suffix');
            $table->unsignedBigInteger('host_manager_id');


            $table->foreign('host_manager_id')->references('id')->on('host_managers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosts');
    }
};
