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
            $table->unsignedBigInteger('question_id');
            $table->foreign("question_id")->references("id")->on("questions")->onDelete("cascade");
            $table->unsignedBigInteger('sub_question_id')->nullable();
            $table->foreign("sub_question_id")->references("id")->on("sub_questions")->onDelete("cascade");
            $table->text("answer_text");
            $table->string("answer_image",255)->nullable();
            $table->enum("order",[1,2,3,4])->nullable();
            $table->enum("is_correct",[0,1]);
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
