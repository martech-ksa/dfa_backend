<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            $table->foreignId('class_arm_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained()
                ->cascadeOnDelete();

            // Term example: First, Second, Third
            $table->string('term');

            // Scores
            $table->unsignedInteger('ca_score')->default(0);
            $table->unsignedInteger('exam_score')->default(0);

            $table->unsignedInteger('total')->default(0);

            $table->string('grade')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Result Entries
            |--------------------------------------------------------------------------
            | A student should not have two results for the same:
            | subject + class + session + term
            */

            $table->unique(
                [
                    'student_id',
                    'subject_id',
                    'class_arm_id',
                    'academic_session_id',
                    'term'
                ],
                'student_result_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};