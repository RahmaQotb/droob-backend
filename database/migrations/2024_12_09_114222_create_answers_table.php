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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreign("sub_question_id")->references("id")->on("sub_questions");
            $table->foreign("question_id")->references("id")->on("questions");
            $table->text("answer_text");
            $table->string("answer_image",255)->nullable();
            $table->string("order",255)->nullable();
            $table->string("is_correct",255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
