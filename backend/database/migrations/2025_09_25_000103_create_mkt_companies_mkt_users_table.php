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
        Schema::create('mkt_companies_mkt_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_company_id');
            $table->unsignedBigInteger('marketing_user_id');
            $table->unsignedBigInteger('marketing_user_type_id');

            $table->foreign('marketing_company_id')->references('id')->on('marketing_companies');
            $table->foreign('marketing_user_id')->references('id')->on('marketing_users');
            $table->foreign('marketing_user_type_id')->references('id')->on('marketing_user_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_companies_marketing_users');
    }
};
