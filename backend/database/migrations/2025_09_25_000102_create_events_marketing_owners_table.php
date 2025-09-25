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
        Schema::create('events_marketing_owners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketing_owner_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('marketing_company_id');
            $table->unsignedBigInteger('marketing_owner_type_id');


            
            $table->foreign('marketing_owner_id')->references('id')->on('marketing_owners')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('marketing_company_id')->references('id')->on('marketing_companies');
            $table->foreign('marketing_owner_type_id')->references('id')->on('marketing_owner_type');

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
