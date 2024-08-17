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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');#FK
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');#FK
            $table->foreignId('action_id')->constrained()->onDelete('cascade');#FK
            $table->foreignId('calendar_id')->constrained()->onDelete('cascade');#FK
            $table->string('title', 50);
            $table->string('note', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
