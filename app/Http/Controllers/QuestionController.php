<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
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
            'text' => 'required',
            'submit' => 'required'
        ]);

//        dd($data);

        $question = new Question;
//        $question->fill($data);
        $question->text = $data['text'];
        $question->owner()->associate(auth()->id());
        $question->save();

        // params
        $q_id = $question->id;
        $back = 'home';
//

        if ($data['submit'] === 'Save and Close') {
            $request->session()->flash('message', 'Question saved successfully. In order to publish question you need to add answers.');
            return redirect()->route('home');
        } elseif ($data['submit'] === 'Create Answers') {
//            $request->session()->put('question', ['id' => $question->id]);
            return redirect()->route('answers.create', ['question' => $q_id, 'back' => $back]);
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

//        $question = $question1;
        $message = request()->session()->has('message')
            ? request()->session()->get('message')
            : null;

        /*if ($message) {
            echo $message;
        }*/




//        dd($question->beenAnswered);
//        dd(Question::find(1)->beenAnswered);
//        dd($question->loadCount('answers'));

        /*
        $question = Question::find(1);
        foreach ($question->answers as $answer) {
            echo $answer->answeredCorrect ? 'correct' .  '<br>' : 'wrong' .  '<br>';
        }
//        $answer = Answer::find(3)->answeredCorrect;
        dd(111);
        */

//        dd(Question::find(2)->answeredCorrect);


//        dd(Question::find($question->id)->answered);

//        dd(Answer::find(1)->answeredByExists);

        /***********************/

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
            'text' => 'required',
            'submit' => 'required'
        ]);

//        dd($data);

        $question->text = $data['text'];
        $question->save();

        if ($data['submit'] === 'Save and Close') {
            $request->session()->flash('message', 'Question "' . $question->id . '" edited successfully!');
            return redirect()->route('home');
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
