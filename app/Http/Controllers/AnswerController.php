<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{

    private $question = null;

    public function __construct()
    {
        $this->middleware('auth');

        if (request()->has('question')) {
            $id = request()->query('question');
            $question = Question::findOrFail($id);
            $this->question = $question;
//            $answers = Answer::where('question_id', $id)->get();
//            dd($question);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $this->authorize('view-answers', $this->question);

        $answers = $this->question->answers;

        return view('answers.index', [
            'answers' => $answers,
            'question' => $this->question,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create-answers', $this->question);

        $answers = $this->question->answers;

//        dd($question_id);
        return view('answers.create', [
            'question' => $this->question,
            'answers' => $answers,

        ]);
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
            'is_correct' => 'numeric',
            'question' => 'required',
        ]);

        $answer = new Answer;

        $answer->text = $data['text'];
        $answer->is_correct = $data['is_correct'];
        $answer->question()->associate($data['question']);
        $answer->save();

//        $q_id = ;
//        $request->session()->flash;
//        return redirect()->route('answers.create');
//        return back();
        // , ['question' => $data['question_id']]
        return redirect()->route('answers.index', ['question' => $this->question])
            ->with('success-message', 'Answer successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return view('answers.show', [
            'answer' => $answer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        $this->authorize('edit-answers', $answer);

        return view('answers.edit', [
            'answer' => $answer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {

        $this->authorize('edit-answers', $answer);

        $data = $request->validate([
            'text' => 'required',
            'is_correct' => 'numeric',
        ]);

        $answer->text = $data['text'];
        $answer->is_correct = $data['is_correct'];
        $answer->save();

        $q_id = $answer->question->id;


        $request->session()->flash('message', 'Answer "' . $answer->text . '" edited successfully!');


        return redirect()->route('answers.index', ['question' => $q_id]);
        /*$data = $request->validate([
            'text' => 'required|min:5',
            'is_right' => 'numeric',
            'question_id' => 'required',
        ]);
        $answer = new Answer;

        $answer->text = $data['text'];
        $answer->is_right = $data['is_right'];
        $answer->question()->associate($data['question_id']);
        $answer->save();

        $request->session()->flash('message', 'Answer successfully created');
        return redirect()->route('answers.create');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $this->authorize('delete-answer', $answer);

        $answer_text = $answer->text;
        $answer->delete();
        request()->session()->flash('message', 'Answer "' . $answer_text . '" successfully deleted!');
        return back();
    }

    public function answerQuestion(Request $request)
    {
//        dd($request->all());

        $validator = Validator::make($request->all(), [
            'answers' => 'required',
            'question_id' => 'required'
        ],
        [
            'answers.required' => 'At least one of :attribute is required',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $data = $validator->validated();

        $question_id = $data['question_id'];

//        dd($data['answers']);

//        echo 'Q id: ' . $question_id;
//        dd($answers);


        $current_user = User::find(auth()->id());

//        $attach = [];
//        date_default_timezone_set('Europe/Nicosia');
//        date('Y-m-d H:i:s')


        $current_user->answeredAnswers()->attach($data['answers']);

//        request()->session()->flash('message', 'Answered successfully!');
        return back()->with('success-message', 'Answered successfully!');



        /*foreach($answers as $key => $value) {
            echo nl2br('Answer ID: ' . $key . ' Checked: ' . $value . "\n");
            $db_answer = Answer::find($key);
            if ($db_answer->is_right == $value) {
                $current_user->answered()->attach($db_answer, ['answered_right' => true]);
            } else {
                $current_user->answered()->attach($db_answer, ['answered_right' => false]);
            }
        }*/
    }


}
