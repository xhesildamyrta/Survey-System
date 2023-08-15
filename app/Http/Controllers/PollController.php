<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Models\Answer;
use App\Models\Response;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

class PollController extends Controller
{
    public function index()
    {
        $poll = Poll::all();
        $votes = null;

        return view('pages.welcome', compact('poll', 'votes'));
    }

    public function show($id)
    {
        $poll = Poll::find($id);
        return view('pages.single-poll', ['poll' => $poll]);
    }

    public function submitPoll(Request $request)
    {
        $ip = $this->getIPAddress();
        $userAgent = $request->header('User-Agent');

        $existingVote = Response::where('ip_address', $ip)
            ->where('computer_id', $userAgent)
            ->first();
        $poll = Poll::find($request['poll_id']);

        $rules = [];

        foreach ($poll->questions as $question) {
            $rules['question' . $question->id] = 'required';
        }

        $validated = $request->validate($rules);

        if ($validated) {
            $jsonData = [];
            foreach ($validated as $key => $value) {
                if ($key !== 'poll_id') {
                    $questionId = substr($key, strlen('question'));
                    $jsonData['question' . $questionId] = [
                        'question_id' => $questionId,
                        'question_title' => $poll->questions->find($questionId)['title'],
                        'answer_id' => $value,
                        'answer_title' => $poll->questions->find($questionId)->answers->find($value)['title'],
                    ];
                }
            }
            $jsonVote = json_encode($jsonData);
        }

        // if ($request->hasCookie('voted') || $existingVote) {
        //     return redirect()
        //         ->back()
        //         ->with('error', 'You have already voted!');
        // }


        $response = new Response();
        $response->ip_address = $ip;
        $response->computer_id = $userAgent;
        $response->poll_id = $request['poll_id'];
        $response->vote = $jsonVote;
        $response->save();


        return redirect()
            ->back()
            ->with('success', 'Answer submitted successfully!')->cookie('voted', true, 10080);
    }



    public function getIPAddress()
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.ipify.org?format=json');
            $data = json_decode($response->getBody(), true);
            $publicIPAddress = $data['ip'];

            return $publicIPAddress;
        } catch (\Exception $e) {
            return 'Error occurred while retrieving public IP address.';
        }
    }

    public function showResults($id)
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
        return view('pages.single-poll-results', ['results' => $results, 'totalVotes' => $totalVotes]);
    }

    public function calculateDateTimeDifference()
    {
        $latest_date_voted = Response::latest()->first()->created_at ?? null;

        if (is_null($latest_date_voted)) {
            return;
        }

        $currentDateTime = Carbon::now();
        $specificDateTime = Carbon::parse($latest_date_voted);

        $diffInMinutes = $currentDateTime->diffInMinutes($specificDateTime);

        if ($diffInMinutes < 2) {
            return 'Just now';
        } else {
            $diff = $currentDateTime->diff($specificDateTime);

            $days = $diff->d;
            $hours = $diff->h;
            $minutes = $diff->i;

            $result = '';

            if ($days > 0) {
                $result .= $days . ' day' . ($days > 1 ? 's ' : ' ');
            }
            if ($hours > 0) {
                $result .= $hours . ' hour' . ($hours > 1 ? 's ' : ' ');
            }
            $result .= $minutes . ' minute' . ($minutes > 1 ? 's ago' : '');

            return $result;
        }
    }
}
