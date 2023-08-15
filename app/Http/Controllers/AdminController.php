<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Poll;
use App\Models\User;
use App\Models\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function seeAdminList()
    {
        $admins = User::paginate(10);

        return view('pages.admin-list', ['users' => $admins]);
    }

    public function addAccount(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password']));
        return redirect()->route('admin.list')->with('success', 'New admin created successfully');
    }

    public static function pollResults($id)
    {
        $poll = Poll::findOrFail($id);
        $votes = Response::where('poll_id', $id)->get();
        $totalVotes = count($votes);

        $votesPerAnswer = [];
        $totalVotesPerQuestion = [];

        $results = [];

        foreach ($poll->questions as $question) {
            $votesPerAnswer[$question->id] = [];
            $totalVotesPerQuestion[$question->id] = 0;
            foreach ($question->answers as $answer) {
                $votesPerAnswer[$question->id][$answer->id] = 0;
            }
        }
        foreach ($votes as $vote) {
            $voteData = json_decode($vote->vote, true);
            foreach ($voteData as $questionId => $answerData) {
                if (str_starts_with($questionId, 'question')) {
                    $questionId = substr($questionId, strlen('question'));
                    $answerId = $answerData['answer_id'];
                    $votesPerAnswer[$questionId][$answerId]++;
                    $totalVotesPerQuestion[$questionId]++;
                }
            }
        }
        foreach ($poll->questions as $question) {
            $results['question' . $question->id] = [
                'question_id' => $question->id,
                'question_title' => $question->title,
                'answers' => [],
            ];
            foreach ($question->answers as $answer) {
                $votes = $votesPerAnswer[$question->id][$answer->id];
                $totalVotes = $totalVotesPerQuestion[$question->id];
                $percentage = ($totalVotes > 0) ? ($votes / $totalVotes) * 100 : 0;
                $results['question' . $question->id]['answers'][] = [
                    'answer_id' => $answer->id,
                    'answer_title' => $answer->title,
                    'votes' => $votes,
                    'percentage' => number_format($percentage, 2),
                ];
            }
        }
        return $results;
    }

    public function seePollsList()
    {
        $polls = Poll::paginate(10);
        return view('pages.polls-list', compact('polls'));
    }

    public function newPoll()
    {
        return view('pages.new-poll');
    }

    public function createPoll(Request $request)
    {
        $this->validate(request(), [
            'poll_title' => 'required',
            'question_title' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'nullable',
            'option_4' => 'nullable',
        ]);

        try {
            $poll = Poll::create([
                'title' => $request['poll_title']
            ]);

            $poll_id = $poll->id;
            $question = Question::create([
                'title' => $request['question_title'],
                'poll_id' => $poll_id = $poll->id,
            ]);

            for ($i = 1; $i < 5; $i++) {
                if (isset($request['option_' . $i]) && $request['option_' . $i]) {
                    $answers = Answer::create([
                        'title' => $request['option_' . $i],
                        'points' => 0,
                        'question_id' => $question->id,
                        'poll_id' => $poll_id,
                    ]);
                }
            }
            return redirect()->route('create-poll')->with('success', 'New poll created successfully!');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
