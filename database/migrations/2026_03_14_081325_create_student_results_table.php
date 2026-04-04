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
        Schema::create('student_results', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('subject_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('ca')->nullable();

            $table->integer('exam')->nullable();

            $table->integer('total')->nullable();

            $table->string('grade')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};