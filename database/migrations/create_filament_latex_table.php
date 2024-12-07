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
        // Dont forget to delete (DEV ONLY)
        if (Schema::hasTable('filament-latex')) {
            Schema::dropIfExists('filament-latex');
        }
        Schema::create('filament-latex', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filament-latex');
    }
};
