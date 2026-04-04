<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_results', function (Blueprint $table) {
            $table->foreignId('class_arm_id')
                  ->nullable()
                  ->after('student_id')
                  ->constrained()
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('student_results', function (Blueprint $table) {
            $table->dropForeign(['class_arm_id']);
            $table->dropColumn('class_arm_id');
        });
    }
};