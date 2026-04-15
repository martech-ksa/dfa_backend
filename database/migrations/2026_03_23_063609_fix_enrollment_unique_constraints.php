<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 🔹 STEP 1: DROP OLD UNIQUE (SAFE CHECK)
        if ($this->indexExists('enrollments', 'enrollments_student_class_session_unique')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->dropUnique('enrollments_student_class_session_unique');
            });
        }

        // 🔹 STEP 2: DROP ALTERNATIVE INDEX NAME (IF EXISTS)
        if ($this->indexExists('enrollments', 'student_class_session_unique')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->dropUnique('student_class_session_unique');
            });
        }

        // 🔹 STEP 3: ADD NEW UNIQUE (ONLY IF NOT EXISTS)
        if (!$this->indexExists('enrollments', 'student_program_session_unique')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->unique(
                    ['student_id', 'program_id', 'academic_session_id'],
                    'student_program_session_unique'
                );
            });
        }
    }

    public function down(): void
    {
        // 🔹 REMOVE NEW INDEX SAFELY
        if ($this->indexExists('enrollments', 'student_program_session_unique')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->dropUnique('student_program_session_unique');
            });
        }

        // 🔹 RESTORE OLD INDEX (IF NOT EXISTS)
        if (!$this->indexExists('enrollments', 'student_class_session_unique')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->unique(
                    ['student_id', 'class_arm_id', 'academic_session_id'],
                    'student_class_session_unique'
                );
            });
        }
    }

    /**
     * 🔍 CHECK IF INDEX EXISTS
     */
    private function indexExists($table, $index)
    {
        $result = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = '{$index}'");
        return count($result) > 0;
    }
};