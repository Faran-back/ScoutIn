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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo');
            $table->string('company_name');
            $table->string('company_webiste');
            $table->string('number_of_employees');
            $table->string('industry');
            $table->string('country');
            $table->string('social_media');
            $table->longText('about_your_company');
            $table->string('mission');
            $table->string('benefits');
            $table->string('values');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
