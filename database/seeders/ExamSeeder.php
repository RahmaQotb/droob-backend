<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a normal exam
        $normalExam = Exam::create([
            'name' => 'Normal Exam',
            'subject_id' => 1, // Assuming subject_id 1 exists
            'type' => 'normal',
        ]);

        // Create questions for the normal exam
        for ($i = 1; $i <= 5; $i++) {
            $question = Question::create([
                'text' => 'Normal Exam Question ' . $i,
                'type' => 'mcq',
                'image' => null,
                'exam_id' => $normalExam->id,
            ]);

            // Create answers for each question
            for ($j = 1; $j <= 4; $j++) {
                Answer::create([
                    'text' => 'Answer ' . $j . ' for Question ' . $i,
                    'image' => null,
                    'is_correct' => $j == 1, // First answer is correct
                    'order' => $j,
                    'question_id' => $question->id,
                ]);
            }
        }

        // Create a passage-based exam
        $passageExam = Exam::create([
            'name' => 'Passage Based Exam',
            'subject_id' => 2, // Assuming subject_id 2 exists
            'type' => 'passage_based',
        ]);

        // Create a passage for the passage-based exam
        $passage = Question::create([
            'text' => 'This is a passage text.',
            'type' => 'passage',
            'image' => null,
            'exam_id' => $passageExam->id,
        ]);

        // Create questions for the passage
        for ($i = 1; $i <= 3; $i++) {
            $question = Question::create([
                'text' => 'Passage Question ' . $i,
                'type' => 'mcq',
                'image' => null,
                'exam_id' => $passageExam->id,
                'parent_question_id' => $passage->id, // Assuming you have a parent_id column for sub-questions
            ]);

            // Create answers for each question
            for ($j = 1; $j <= 4; $j++) {
                Answer::create([
                    'text' => 'Answer ' . $j . ' for Passage Question ' . $i,
                    'image' => null,
                    'is_correct' => $j == 1, // First answer is correct
                    'order' => $j,
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}