<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('staff_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('date');

            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();

            $table->string('status')->default('present');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_within_geofence')->default(false);

            $table->timestamps();

            $table->unique(['staff_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};