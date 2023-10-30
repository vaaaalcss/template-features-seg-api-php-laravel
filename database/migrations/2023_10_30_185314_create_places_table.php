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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('streetName')->nullable();
            $table->string('streetNumber')->nullable();
            $table->string('interiorNumber')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('municipallity')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('reference')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('owner')->nullable();
            $table->time('openingHour')->nullable();
            $table->time('closingHour')->nullable();
            $table->string('open')->default('Jueves, Viernes, Sábado, Domingo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
