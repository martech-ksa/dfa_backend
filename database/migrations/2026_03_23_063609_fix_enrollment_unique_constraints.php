<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {

            // ❌ REMOVE OLD CONSTRAINT
            $table->dropUnique('enrollments_student_class_session_unique');

            // OR if Laravel named it differently, try this instead:
            // $table->dropUnique(['student_id','class_arm_id','academic_session_id']);
        });

        Schema::table('enrollments', function (Blueprint $table) {

            // ✅ ENSURE NEW CONSTRAINT EXISTS
            $table->unique(
                ['student_id', 'program_id', 'academic_session_id'],
                'student_program_session_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {

            $table->dropUnique('student_program_session_unique');

            // Restore old (optional)
            $table->unique(
                ['student_id', 'class_arm_id', 'academic_session_id'],
                'student_class_session_unique'
            );
        });
    }
};