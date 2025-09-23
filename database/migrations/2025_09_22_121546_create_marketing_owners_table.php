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
        Schema::create('marketing_owners_table', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->unsignedBigInteger('suffix_id')->nullable();
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

            $table->foreign('suffix_id')->references('id')->on('suffix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_owners_table');
    }
};
