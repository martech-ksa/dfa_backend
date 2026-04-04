<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            // Program Name (Conventional, Creche, Islamiyya, Tahfiz)
            $table->string('name')->unique();

            // Academic, Religious, Early Years
            $table->string('category');

            // Mon-Fri, Sat-Sun, Mon-Wed Evening
            $table->string('schedule')->nullable();

            // Optional description
            $table->text('description')->nullable();

            // Enable/Disable program
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};