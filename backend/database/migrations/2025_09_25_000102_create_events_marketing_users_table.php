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
        Schema::create('events_marketing_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_user_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('marketing_company_id');



            
            $table->foreign('marketing_user_id')->references('id')->on('marketing_users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('marketing_company_id')->references('id')->on('marketing_companies');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_marketing_owners');
    }
};
