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
        Schema::create('section_classes', function (Blueprint $table) {
            $table->id();

            // Class Name (Nursery 1, Basic 1, JSS 1, etc.)
            $table->string('name');

            // Link to programs table
            $table->foreignId('program_id')
                  ->constrained('programs')
                  ->cascadeOnDelete();

            // Enable/Disable class
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_classes');
    }
};