<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $message = request()->session()->has('message')
            ? request()->session()->get('message')
            : null;

        $questions = Question::ownQuestions()->get();

        return view('home', [
            'questions' => $questions,
            'message' => $message,
        ]);
    }




}
