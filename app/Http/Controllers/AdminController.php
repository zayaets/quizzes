<?php

namespace App\Http\Controllers;

use App\Question;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function question(Question $question)
    {
//        $statuses = Status::all();
        return view('admin.question', [
            'question' => $question,
//            'statuses' => $statuses,
        ]);
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())->sortable()->paginate(10);

        return view('admin.users', [
            'users' => $users,
        ]);
    }

    public function status(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|numeric',
            'status' => 'required',
            'note' => 'required_if:status,rejected|max:191',
        ]);

        // get the Question
        $question = Question::findOrFail($data['question']);

        // check if isValid
        if (!$question->isValid()) {
            return back()->with('error-message', 'The Question is invalid.');
        }

        // get Status to change to
        $to_status = $question->availableStatuses()->where('slug', $data['status'])->first();

        $from_status = $question->status->slug;
//        $not_for_publishing = ['draft', 'rejected'];
        $status_array = [
            'published' => [
                'to' => [
                    'hidden',
                    'awaiting_approval'
                ]
            ],
            'draft' => [
                'to' => [
                    'awaiting_approval',
                ]
            ],
            'awaiting_approval' => [
                'to' => [
                    'published',
                    'rejected'
                ]
            ],
            'rejected' => [
                'to' => [
                    'awaiting_approval',
                    'draft'
                ]
            ],
            'hidden' => [
                'to' => [
                    'published',
                ]
            ],
        ];

        if (array_key_exists($from_status, $status_array)) {
            if (!in_array($data['status'], $status_array[$from_status]['to'])) {
                return back()->with('error-message', 'Sorry, you can not change "' . ucfirst($from_status) . '" to "' . ucfirst($data['status']) . '"');
            }

            if (strlen($data['note']) > 0) {
                $question->note = $data['note'];
            }
            $question->status()->associate($to_status);
            $question->save();
            return back()->with('success-message', 'Successfully changed status to "' . $to_status->slug . '"');
        }

        abort(404);
    }

    public function publish(Question $question)
    {
        /**
         * this is deprecated
         */
        exit();
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
