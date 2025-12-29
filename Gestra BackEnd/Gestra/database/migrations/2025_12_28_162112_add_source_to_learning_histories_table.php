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
        Schema::table('learning_histories', function (Blueprint $table) {
        if (!Schema::hasColumn('learning_histories', 'source')) {
            $table->string('source')->after('accuracy');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::table('learning_histories', function (Blueprint $table) {
            //
        });
    }
};
