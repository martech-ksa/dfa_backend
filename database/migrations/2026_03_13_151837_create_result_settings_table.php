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
        Schema::create('result_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('ca1')->default(20);
            $table->integer('ca2')->default(20);
            $table->integer('attendance')->default(10);
            $table->integer('exam')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_settings');
    }
};