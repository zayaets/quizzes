<?php

namespace App\Http\Controllers;

use App\Question;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
//        $this->authorize('isAdmin');
        $this->middleware('can:isAdmin');

    }

    public function index()
    {
        return view('admin.index');
    }
    public function questions()
    {
        $questions = Question::sortable()->paginate(10);
        return view('admin.questions', [
            'questions' => $questions,
        ]);
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())->sortable()->paginate(10);

        return view('admin.users', [
            'users' => $users,
        ]);
    }

    public function publish(Question $question)
    {
        if ($question->isValid()) {
            $question->published = 1;
            $question->save();

            return back()->with('message', [
                'status' => 'success',
                'text' => 'Published successfully!'
            ]);
        }

        return back()->with('message', [
            'status' => 'error',
            'text' => 'Question can not be published. Please check if question has at least 2 answers and one of them is correct'
        ]);
    }

    public function unpublish(Question $question)
    {
        if ($question->published === true) {
            $question->published = 0;
            $question->save();
            return back()->with('message', [
                'status' => 'success',
                'text' => 'Unpublished successfully!'
            ]);
        }

        return back()->with('message', [
            'status' => 'error',
            'text' => 'In order to unpublish question, first you need to publish it.'
        ]);

    }
}
