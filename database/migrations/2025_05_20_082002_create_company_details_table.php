<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('company_logo')->nullable();
            $table->string('company_name');
            $table->string('company_website');
            $table->string('number_of_employees');
            $table->string('industry');
            $table->string('country')->nullable();
            $table->string('social_media')->nullable();
            $table->longText('about_your_company')->nullable();
            $table->string('mission')->nullable();
            $table->string('benefits')->nullable();
            $table->string('values')->nullable();
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
