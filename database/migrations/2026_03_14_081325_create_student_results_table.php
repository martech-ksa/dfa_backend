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
        // ✅ Create table only if it does NOT exist
        if (!Schema::hasTable('student_results')) {

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

                // ✅ Prevent duplicate entries per student per subject
                $table->unique(['student_id', 'subject_id'], 'student_subject_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ Drop only if exists (safe rollback)
        if (Schema::hasTable('student_results')) {
            Schema::dropIfExists('student_results');
        }
    }
};