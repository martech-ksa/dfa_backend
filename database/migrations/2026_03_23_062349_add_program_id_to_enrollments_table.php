<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | STEP 1: Ensure program_id exists (DO NOT RE-CREATE)
        |--------------------------------------------------------------------------
        */
        if (!Schema::hasColumn('enrollments', 'program_id')) {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->foreignId('program_id')->nullable()->after('student_id');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 2: Populate program_id from class_arm → level → program
        |--------------------------------------------------------------------------
        */
        DB::statement("
            UPDATE enrollments e
            JOIN class_arms ca ON ca.id = e.class_arm_id
            JOIN levels l ON l.id = ca.level_id
            SET e.program_id = l.program_id
            WHERE e.program_id IS NULL
        ");

        /*
        |--------------------------------------------------------------------------
        | STEP 3: Drop OLD unique constraint (if exists)
        |--------------------------------------------------------------------------
        */
        try {
            DB::statement("
                ALTER TABLE enrollments
                DROP INDEX student_class_session_unique
            ");
        } catch (\Exception $e) {
            // ignore if it doesn't exist
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 4: Add new UNIQUE constraint (student + program + session)
        |--------------------------------------------------------------------------
        */
        try {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->unique(
                    ['student_id', 'program_id', 'academic_session_id'],
                    'student_program_session_unique'
                );
            });
        } catch (\Exception $e) {
            // ignore if already exists
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 5: Add FOREIGN KEY (if not already added)
        |--------------------------------------------------------------------------
        */
        try {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->foreign('program_id')
                      ->references('id')
                      ->on('programs')
                      ->cascadeOnDelete();
            });
        } catch (\Exception $e) {
            // ignore if already exists
        }

        /*
        |--------------------------------------------------------------------------
        | STEP 6: Make column NOT NULL (optional but recommended)
        |--------------------------------------------------------------------------
        */
        try {
            DB::statement("
                ALTER TABLE enrollments
                MODIFY program_id BIGINT UNSIGNED NOT NULL
            ");
        } catch (\Exception $e) {
            // ignore if already set
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Rollback safely
        |--------------------------------------------------------------------------
        */
        try {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->dropUnique('student_program_session_unique');
            });
        } catch (\Exception $e) {}

        try {
            Schema::table('enrollments', function (Blueprint $table) {
                $table->dropForeign(['program_id']);
            });
        } catch (\Exception $e) {}

        // We DO NOT drop program_id column to avoid data loss
    }
};