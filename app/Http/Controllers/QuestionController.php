<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\StoreQuestion as StoreQuestionRequest;
use App\Http\Requests\UpdateQuestion as UpdateQuestionRequest;
use App\Question;
use App\Role;
use App\User;
use DebugBar\DebugBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->authorizeResource(Question::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $questions = Question::ownQuestions()->get(); // ->paginate(1)
        $questions = Question::othersQuestions()->published()->sortable()->paginate(10);
//        $answered_questions = User::answeredQuestions();
//        dd($questions);

        return view('questions.index', [
            'questions' => $questions,
//            'answered_questions' => $answered_questions,
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();

        $submit = $data['submit'];
        unset($data['submit']);

//        dd($data);

        $question = new Question;
        $question->fill($data);
//        $question->title = $data['title'];
//        $question->text = $data['text'];
        $question->owner()->associate(auth()->id());
        $question->save();


        if ($submit === 'Save and Close') {
//            $request->session()->flash('message', 'text');
            return redirect()->route('user.questions')->with('message', 'Question saved successfully. In order to publish question you need to add answers.');
        } elseif ($submit === 'Create Answers') {
            return redirect()->route('answers.create', ['question' => $question->id]);
        }

        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {

        return view('questions.show', [
            'question' => $question,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {

        return view('questions.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $data = $request->validated();

//        dd($data);
        $submit = $data['submit'];
        unset($data['submit']);
        $question->fill($data);
//        $question->title = $data['title'];
//        $question->text = $data['text'];
        $question->save();

        if ($submit === 'Save and Close') {
//            $request->session()->flash();
            return redirect()->route('user.questions')->with('success-message', 'Question "' . $question->title . '" edited successfully!');
        }

        abort(404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $title = $question->title;
        $question->delete();

//        request()->session()->flash('message', 'Question "' . $title . '" successfully deleted!');
        return back()->with('success-message', 'Question "' . $title . '" successfully deleted!');
    }





}
