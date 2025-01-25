<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('base_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 255);
            $table->unsignedBigInteger('base_exam_id');
            $table->foreign('base_exam_id')->references('id')->on('base_exams')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_questions');
    }
};
