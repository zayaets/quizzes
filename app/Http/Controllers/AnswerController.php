<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateAnswer as UpdateAnswerRequest;
use App\Http\Requests\StoreAnswer as StoreAnswerRequest;
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

        $this->isQuestion();

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
        $this->isQuestion();

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
    public function store(StoreAnswerRequest $request)
    {
        $this->isQuestion();

        $this->authorize('create-answers', $this->question);

        $data = $request->validated();
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
        $this->isQuestion();

        $this->authorize('update-answers', [$this->question, $answer]);

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
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {

        $this->isQuestion();

        $this->authorize('update-answers', [$this->question, $answer]);

        $data = $request->validated();

        $answer->fill($data);
//        $answer->text = $data['text'];
//        $answer->is_correct = $data['is_correct'];
        $answer->save();

//        $request->session()->flash();

        return redirect()->route('answers.index', ['question' => $answer->question->id])
            ->with('success-message', 'Answer "' . $answer->text . '" edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $this->isQuestion();

        $this->authorize('delete-answer', $answer);

        $answer_text = $answer->text;
        $answer->delete();
//        request()->session()->flash();
        return back()->with('message', 'Answer "' . $answer_text . '" successfully deleted!');
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


        $current_user->answeredAnswers()->attach($data['answers']);

        return back()->with('success-message', 'Answered successfully!');
    }

    private function isQuestion()
    {
        if (is_null($this->question)) {
            abort(403, 'You have no access.');
        }
    }


}
