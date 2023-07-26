<?php

namespace App\Http\Controllers;

use App\Models\Answer;
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

    public static function pollResults($id){
    $poll = Poll::with('answers')->find($id);

    if (!$poll) {
        return null; // Poll not found
    }
    $pollTitle = $poll->title;

    $totalResponses = $poll->responses->count();

    $results = $poll->answers->map(function ($answer) use ($totalResponses) {
        $votes = $answer->responses->count();
        $percentage = ($totalResponses > 0) ? ($votes / $totalResponses) * 100 : 0;

        return [
            'answer' => $answer->title,
            'votes' => $votes,
            'percentage' => number_format($percentage,2),
        ];
    });
    return $results;
    }

    public function seePollsList(){
        $polls = Poll::paginate(10);
        return view('pages.polls-list',compact('polls'));

    }

    public function newPoll()
    {
        return view('pages.new-poll');
    }

    public function createPoll(Request $request)
    {
        $this->validate(request(), [
            'poll_title' => 'required',
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

            for ($i = 1; $i < 5; $i++) {
                if (isset($request['option_' . $i]) && $request['option_' . $i]) {
                    $answers = Answer::create([
                        'title' => $request['option_' . $i],
                        'poll_id' => $poll_id,
                    ]);
                }
            }
            return redirect()->route('create-poll')->with('success','New poll created successfully!');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
