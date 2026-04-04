<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // KG1, Basic 1, JSS 1
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['name', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};