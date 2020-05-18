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


        $questions = Question::ownQuestions()->get();

        return view('home', [

        ]);
    }

    public function questions()
    {
        $questions = Question::ownQuestions()->sortable()->paginate(10);

        return view('user.questions', [
            'questions' => $questions,
        ]);
    }

    public function question(Question $question)
    {
        $this->authorize('view-dashboard-question', $question);

        return view('user.question', [
            'question' => $question,
        ]);
    }


}
