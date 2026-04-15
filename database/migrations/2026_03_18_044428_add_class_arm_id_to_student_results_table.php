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
        // ✅ Add column ONLY if it does not exist
        if (!Schema::hasColumn('student_results', 'class_arm_id')) {

            Schema::table('student_results', function (Blueprint $table) {

                $table->foreignId('class_arm_id')
                      ->nullable()
                      ->after('student_id')
                      ->constrained()
                      ->cascadeOnDelete();

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ Drop column ONLY if it exists
        if (Schema::hasColumn('student_results', 'class_arm_id')) {

            Schema::table('student_results', function (Blueprint $table) {

                $table->dropForeign(['class_arm_id']);
                $table->dropColumn('class_arm_id');

            });
        }
    }
};