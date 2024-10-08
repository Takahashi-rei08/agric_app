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
        Schema::create('plantVariety_city', function (Blueprint $table) {
            $table->foreignId('plantVariety_id')->nullable(true)->constrained();#FK
            $table->foreignId('city_id')->nullable(true)->constrained();#FK
            $table->primary(['plantVariety_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantVariety_city');
    }
};
