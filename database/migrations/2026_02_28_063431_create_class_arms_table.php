<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_arms', function (Blueprint $table) {
            $table->id();

            $table->string('arm'); // A, B, C
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['arm', 'level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_arms');
    }
};