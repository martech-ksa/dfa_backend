<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('class_arm_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('academic_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Unique Constraint
            |--------------------------------------------------------------------------
            | A student:
            | - Can enroll in multiple programs in same session
            | - Cannot enroll twice in same class_arm in same session
            */
            $table->unique(
                ['student_id', 'class_arm_id', 'academic_session_id'],
                'student_class_session_unique'
            );

            /*
            |--------------------------------------------------------------------------
            | Performance Indexes (IMPORTANT)
            |--------------------------------------------------------------------------
            */
            $table->index('student_id');
            $table->index('academic_session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};