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
        Schema::create('marketing_company_table', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Company name
            $table->string('description')->nullable(); // Company description
            $table->string('contact_number')->nullable(); 
            $table->string('email')->nullable(); // email address (string, not bigint)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_company_table');
    }
};
