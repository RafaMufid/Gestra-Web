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
        Schema::create('learning_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user_data')->onDelete('cascade');
            $table->string('gesture_name');
            $table->float('accuracy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_histories');
    }
};
