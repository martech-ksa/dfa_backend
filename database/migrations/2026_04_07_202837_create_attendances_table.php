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
        // ✅ Create table only if it does not exist
        if (!Schema::hasTable('attendances')) {

            Schema::create('attendances', function (Blueprint $table) {

                $table->id();

                $table->foreignId('staff_id')
                      ->constrained('users')
                      ->cascadeOnDelete();

                $table->date('date');

                $table->time('check_in')->nullable();
                $table->time('check_out')->nullable();

                $table->string('status')->default('present'); // present, late, absent

                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();

                $table->boolean('is_within_geofence')->default(false);

                $table->timestamps();

                // ✅ Prevent duplicate attendance per day
                $table->unique(['staff_id', 'date'], 'staff_date_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ✅ Drop only if exists
        if (Schema::hasTable('attendances')) {
            Schema::dropIfExists('attendances');
        }
    }
};