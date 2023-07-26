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
        //count options selected foreach question;
        $votes = null;

        return view('pages.welcome', compact('poll', 'votes'));
    }

    public function show($id){
        $poll = Poll::find($id);
        return view('pages.single-poll',['poll' => $poll]);

    }

    public function submitPoll(Request $request)
    {
        $ip = $this->getIPAddress();
        $userAgent = $request->header('User-Agent');

        if ($request->hasCookie('voted')) {
            return redirect()
                ->back()
                ->with('error', 'You have already voted!');
        }

        $existingVote = Response::where('ip_address', $ip)
            ->where('computer_id', $userAgent)
            ->first();

       $validatedData = $request->validate([
        'question' => 'required'
       ],
       [
        'required' =>'Please chose an answer for the question!'
       ]
       );
       $answer = Answer::where('id',$validatedData['question'])->get()->first();
        // if (!$existingVote) {


            $response = new Response();
            $response->ip_address = $ip;
            $response->computer_id = $userAgent;
            $response->poll_id = $answer['poll_id'];
            $response->answer_id = $validatedData['question'];
            $response->save();

            // Cookie::queue('voted', true, 60);

            return redirect()
                ->back()
                ->with('success', 'Answer submitted successfully!');
                // ->cookie('voted', true, 10080);
        // } else {
        //     return redirect()
        //         ->back()
        //         ->with('error','You(or someone on Your Wi-Fi network) have already participated on this poll!');
        // }
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
        $votes = [];
        $poll_responses = Response::where('poll_id',$id)->get();
        $total = $poll_responses->count();
        $poll = Poll::where('id', $id)->get()->first();
        // dd($poll);


        $results = collect($poll_responses)->map(function($result) use($poll){
            if ($result) {
                return [
                    'result' => [
                        'id' => $result->id,
                        'poll_id'=> $result->poll_id,
                        'answer_id' =>$result->answer_id,
                        'title' => $poll->title,
                        'answer' => Answer::where('id',$result->answer_id)->get()->first()->title,
                    ],
                    'answer_id' =>$result->answer_id,
                ];
            }
        })->groupBy('answer_id')
        ->map(function ($step) {
            return collect($step)->map(function ($item) {
                return $item['result'];
            });
        })
        ->toArray();
        // dd($results);
        $votes_per_answer = [];

        return view('pages.single-poll-results',['results'=>$results,'totalVotes'=>$total ]);
    }

    public static function convertToPercent($votes,$total){

        return number_format((float)(($votes/$total)*100), 2, '.', '');

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
