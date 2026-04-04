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
        Schema::create('students', function (Blueprint $table) {

            $table->id();

            // Unique Admission Number
            $table->string('admission_number')->unique();

            // Student Names
            $table->string('first_name');
            $table->string('other_names', 500)->nullable();
            $table->string('last_name');

            // Gender
            $table->enum('gender', ['male', 'female']);

            // Date of Birth
            $table->date('date_of_birth')->nullable();

            // Student Status
            $table->enum('status', ['active', 'graduated', 'withdrawn'])
                  ->default('active');

            $table->timestamps();

            // Index for quick search performance
            $table->index(['last_name', 'first_name']);
            $table->index('admission_number'); // If needed for search

            // Foreign Keys (If needed)
            // $table->foreignId('program_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};