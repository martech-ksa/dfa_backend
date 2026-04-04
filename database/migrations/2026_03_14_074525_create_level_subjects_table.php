Schema::create('level_subjects', function (Blueprint $table) {

    $table->id();

    $table->foreignId('program_id')->constrained()->cascadeOnDelete();

    $table->foreignId('level_id')->constrained()->cascadeOnDelete();

    $table->foreignId('subject_id')->constrained()->cascadeOnDelete();

    $table->timestamps();

});