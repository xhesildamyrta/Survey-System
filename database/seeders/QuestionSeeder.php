<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'title' => 'Kush eshte alternativa me e mire moderne?',
                'answers' => [
                    ['title' => 'Alternativa 1'],
                    ['title' => 'Alternativa 2'],
                    ['title' => 'Alternativa 3'],
                    ['title' => 'Alternativa 4'],
                ],
            ],
            [
                'title' => 'What is your favorite outdoor activity?',
                'answers' => [
                    ['title' => 'Hiking'],
                    ['title' => 'Camping'],
                    ['title' => 'Other'],
                ],
            ],
        ];
        foreach ($questions as $questionData) {
            $question = Question::create([
                'title' => $questionData['title'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                Answer::create([
                    'title' => $answerData['title'],
                    'question_id' => $question->id,
                ]);
            }
        }
    }
}
