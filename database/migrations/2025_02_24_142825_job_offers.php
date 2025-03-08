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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->enum('contract_type', ['CDI', 'CDD', 'Freelance']);
            $table->string('offer_link');
            $table->timestamp('date_published');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};