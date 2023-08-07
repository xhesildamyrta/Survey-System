<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poll;
use App\Models\Question;
use App\Models\Answer;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polls = [
            [
                'title' => 'First Poll',
                'questions' => [
                    [
                        'question' => 'Kush eshte alternativa me e mire moderne?',
                        'answers' => [
                            ['title' => 'Alternativa 1', 'points' => 10,],
                            ['title' => 'Alternativa 2', 'points' => 5,],
                            ['title' => 'Alternativa 3', 'points' => 3,],
                            ['title' => 'Alternativa 4', 'points' => 1,],
                        ],
                    ],
                    [
                        'question' => 'What is your favorite outdoor activity?',
                        'answers' => [
                            ['title' => 'Hiking', 'points' => 1,],
                            ['title' => 'Camping', 'points' => 10,],
                            ['title' => 'Other', 'points' => 7,],
                        ],
                    ],

                ]
            ],
            //second poll
            [
                'title' => 'Second Poll',
                'questions' => [
                    [
                        'question' => 'What genre of books do you like most',
                        'answers' => [
                            ['title' => 'Social', 'points' => 10,],
                            ['title' => 'Psichology', 'points' => 8,],
                            ['title' => 'Novels', 'points' => 9,],
                            ['title' => 'Romans', 'points' => 0,],
                        ],
                    ],
                    [
                        'question' => 'Are you feeling ok',
                        'answers' => [
                            ['title' => 'yes', 'points' => 2,],
                            ['title' => 'no', 'points' => 3,],
                            ['title' => 'maybe', 'points' => 5,],
                        ],
                    ],

                ]
            ],
            //third poll
            [
                'title' => 'Third Poll: Age identifier',
                'questions' => [
                    [
                        'question' => 'What is you age',
                        'answers' => [
                            ['title' => '10-20', 'points' => 8,],
                            ['title' => '21-30', 'points' => 3,],
                            ['title' => '31-50', 'points' => 2,],
                            ['title' => '>50', 'points' => 4,],
                        ],
                    ],
                ]
            ]
        ];

        foreach ($polls as $poll) {
            $poll = Poll::create([
                'title' => $poll['title'],
            ]);
            foreach ($poll['questions'] as $question) {
                $question = Question::create([
                    'title' => $question['question'],
                    'poll_id' => $poll->id,
                ]);
                foreach ($question['answers'] as $answer) {
                    $answer = Answer::create([
                        'title' => $answer['title'],
                        'points' => $answer['points'],
                        'question_id' => $question->id,
                    ]);
                }
            }
        }
        Question::create([
            'title' => 'Kush eshte alternativa me e mire moderne?',
            'poll_id' =>1,
        ]);
        Question::create([
            'title' => 'What is your favorite outdoor activity?',
            'poll_id' =>1,
        ]);
        for($i=1;$i<5;$i++){
            Answer::create([
            'title' => 'Alternativa '.$i,
            'points' => $i*2,
            'question_id' =>1
        ]);
        }
        for($i=1;$i<5;$i++){
            Answer::create([
            'title' => 'Optsioni '.$i,
            'points' => $i*2,
            'question_id' =>2
        ]);
        }

        Question::create([
            'title' => 'Which option do yo like most',
            'poll_id' =>2,
        ]);
        for($i=1;$i<5;$i++){
            Answer::create([
            'title' => 'Option '.$i,
            'points' => $i*2,
            'question_id' =>3
        ]);
        }
    }
}
