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
        Schema::create('sub_questions', function (Blueprint $table) {
            $table->id();
            $table->foreign("question_id")->references("id")->on("question");
            $table->text("question_text");
            $table->string("question_image",255)->nullable();
            $table->string("correct_answer",255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_questions');
    }
};
