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
        Schema::create('filament-latex', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->bigInteger('author_id');
            $table->json('collaborators_id')->nullable();
            $table->json('attachment')->nullable();
            $table->json('attachment_file_names')->nullable();
            $table->string('parser');
            $table->boolean('strict_compilation')->default(false);
            $table->boolean('paginate')->default(false);
            $table->boolean('pdfjs')->default(true);
            $table->boolean('auto_recompile')->default(false);
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
