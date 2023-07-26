<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function index(){
    return view('pages.login');
   }

   public function login(Request $request){
    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' =>'required',
       ]
       );

   }

   public function createPoll(Request $request){
    $validatedData = $request->validate([
        'question' => 'required'
       ],
       [
        'required' =>'Please chose an answer for the question!'
       ]
       );

   }
}
