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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();#PK
            $table->foreignId('user_id')->constrained()->onDelete('cascade');#FK
            $table->foreignId('plant_id')->nullable(true)->constrained()->onDelete('cascade');#FK
            $table->foreignId('action_id')->nullable(true)->constrained()->onDelete('cascade');#FK
            $table->string('post_title', 50);
            $table->string('post_body', 200)->nullable(true);
            $table->binary('post_image')->nullable(true);
            $table->date('start_date')->comment('開始日');
            $table->date('end_date')->comment('終了日');
            $table->string('event_color')->comment('背景色');
            $table->string('event_border_color')->comment('枠線色');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
