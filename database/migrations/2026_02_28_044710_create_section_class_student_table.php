<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('section_class_student', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('section_class_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['student_id', 'section_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_class_student');
    }
};