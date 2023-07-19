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

        return view('welcome', compact('poll', 'votes'));
    }

    public function show($id){
        $poll = Poll::find($id);
        return view('single-poll',['poll' => $poll]);

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

        foreach($poll_responses as $poll=>$vote){
            dd($vote['answer_id']);


        }
        $votes_per_answer = [];
        // Format wanted
        // $votes = [
        // 'answer1'=>'3votes',
        // 'answer2'=>'5votes',
        // 'answer3'=>'7votes',
        // ];



        // foreach ($votes as $vote) {
        //     $answers = json_decode($vote['selected_option'], true);

        //     foreach ($answers as $answer) {
        //         $questionId = $answer['question_id'];
        //         $selectedOption = $answer['selected_option'];

        //         if (!isset($votesPerQuestion[$questionId][$selectedOption])) {
        //             $votesPerQuestion[$questionId][$selectedOption] = 0;
        //         }

        //         $votesPerQuestion[$questionId][$selectedOption]++;
        //     }
        // }

        // $votesPercentage = [];
        // $totalVotes = 0;

        // foreach ($votesPerQuestion as $questionId => $options) {
        //     $totalVotes = array_sum($options);
        //     $votesPercentage[$questionId] = [];

        //     foreach ($options as $option => $count) {
        //         $percentage = ($count / $totalVotes) * 100;
        //         $votesPercentage[$questionId][$option] = number_format(
        //             $percentage,
        //             2
        //         );
        //     }
        // }

        // $optionVotes = $votesPercentage ?? 0;
        // $latest_vote = $this->calculateDateTimeDifference();
        return view('single-poll-results',['poll'=>$poll]);
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
