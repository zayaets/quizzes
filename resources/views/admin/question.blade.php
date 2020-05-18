@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('admin.questions') }}" class="btn btn-outline-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @includeIf('templates.session_messages')

                        <h4 class="text-center">Change Question's status</h4>
                        <form action="{{ route('admin.question.status') }}" method="post">
                            @csrf

                            <input type="hidden" name="question" value="{{ $question->id }}">

                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-control">
                                        @foreach($question->availableStatuses() as $status)
                                            <option value="{{ $status->slug }}"
                                                {{ (old('status', '') === $status->slug) ? 'selected' : '' }}
                                            >{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="note" class="col-sm-3 col-form-label">Note</label>
                                <div class="col-sm-9">
                                    <input type="text" name="note" id="note" class="form-control">
                                    {{--<small>It's required to provide a note if you change status to 'Rejected'</small>--}}
                                    @includeIf('templates.form_field_has_error', ['field_name' => 'note'])
                                </div>
                            </div>

                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary ml-auto">Change</button>
                            </div>

                            {{--<div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach($question->availableStatuses() as $status)
                                        <option value="{{ $status->id }}">{{ $status->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" name="note" id="note" class="form-control">
                            </div>--}}



                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">


                @if(isset($question))
                    @if(count($question->answers))
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h2>{{ $question->title }} <span class="badge badge-primary">{{ $question->status->title }}</span></h2>

                                @can('can-edit', $question)
                                    <a href="{{ route('questions.edit', ['question' => $question->id]) }}"
                                       class="btn btn-info ml-auto text-light"
                                       data-toggle="tooltip" title="Edit question"><i class="fas fa-pencil-alt"></i></a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        {{ $question->text }}
                                    </div>
                                </div>

                                {{--@if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif--}}



                                {{--<div class="card mb-3">
                                    <div class="card-body">
                                        <form action="{{ route('answers.answer') }}" method="post">
                                            {{ csrf_field() }}

                                            @foreach($question->answers as $answer)
                                                --}}{{--                                        {{ dd($answer->answeredCorrect) }}--}}{{--
                                                <div class="form-group form-check">
                                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                    --}}{{--                                            <input type="hidden" name="question[{{ $question->id }}][{{ $answer->id }}]" value="0">--}}{{--
                                                    <input type="checkbox" name="answers[]" value="{{ $answer->id }}" id="answer-{{ $answer->id }}" class="form-check-input"
                                                        @if($answer->answeredByExists)
                                                            checked
                                                        @endif

                                                        @if($question->answered)
                                                            disabled
                                                        @endif
                                                    >
                                                    <label for="answer-{{ $answer->id }}" class="form-check-label
                                                        @if($question->answered)
                                                            @if($answer->answeredValue === 1)
                                                                bg-success border rounded px-1 text-light
                                                            @elseif($answer->answeredValue === 0)
                                                                bg-danger border rounded px-1 text-light
                                                            @elseif($answer->answeredValue === 2)
                                                                text-secondary
                                                            @endif
                                                        @endif
                                                    ">{{ $answer->text }}
                                                    </label>
                                                    @if($question->answered)
                                                        @if($answer->answeredValue === 1)
--}}{{--                                                            <span class="badge badge-success">Correct</span>--}}{{--
                                                        @elseif($answer->answeredValue === 0)
                                                            <span class="badge badge-danger">Incorrect</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach

                                            @can('answer', $question)
                                                @if(!$question->answered)
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                @endif
                                            @endcan
                                        </form>
                                    </div>
                                </div>--}}
                            </div>
                        </div>



                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Text</th>
                                <th>Is Correct</th>
                                <th>Questions ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($question->answers as $answer)
                                <tr>
                                    <td>{{ $answer->id }}</td>
                                    <td>{{ $answer->text }}</td>
                                    <td>{{ $answer->is_correct }}</td>
                                    <td>{{ $answer->question_id }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{--                        {{ $questions->links() }}--}}
                        </div>


                    @else
                        <p>Question has no answers</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
