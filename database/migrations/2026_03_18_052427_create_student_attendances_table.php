<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('class_arm_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('score')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_attendances');
    }
};