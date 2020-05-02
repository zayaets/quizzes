<?php

namespace App\Http\Controllers;

use App\Answer;
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:191',
            'text' => 'required|max:65000',
            'submit' => 'required',
        ]);

//        dd($data);

        $question = new Question;
//        $question->fill($data);
        $question->title = $data['title'];
        $question->text = $data['text'];
        $question->owner()->associate(auth()->id());
        $question->save();


        if ($data['submit'] === 'Save and Close') {
            $request->session()->flash('message', 'Question saved successfully. In order to publish question you need to add answers.');
            return redirect()->route('home');
        } elseif ($data['submit'] === 'Create Answers') {
//            $request->session()->put('question', ['id' => $question->id]);
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

/*
        $role = Role::where('slug', 'user')->first();
        $perm = $role->permissions;

        $perm['delete-question'] = true;
        $perm['delete-answers'] = true;
        $role->permissions = $perm;
        $role->save();
        */

//        dd(auth()->user()->hasAccess(['create-answers']));
//        dd($question->isValid());

//        dd($question->hasBeenAnswered());


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
        // todo: here need to authorize editing question, user cannot edit it if question has been already once answered


        return view('questions.edit', [
            'question' => $question,
            'beenAnswered' => $question->beenAnswered,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $data = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'submit' => 'required'
        ]);

//        dd($data);

        $question->title = $data['title'];
        $question->text = $data['text'];
        $question->save();

        if ($data['submit'] === 'Save and Close') {
//            $request->session()->flash();
            return redirect()->route('home')->with('success-message', 'Question "' . $question->title . '" edited successfully!');
        } elseif ($data['submit'] === 'Edit Answers') {
//            $request->session()->put('question', ['id' => $question->id]);
//            return redirect()->route('answers.edit');
//            return redirect()->route('answers.index');

            return back();
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
        $question_text = $question->text;

        $question->delete();

        request()->session()->flash('message', 'Question "' . $question_text . '" successfully deleted!');
        return back();
    }





}
