@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex">
{{--                    <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-outline-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>--}}


                    <a href="{{ route('answers.index', ['question' => $question->id]) }}" class="btn btn-info text-light mb-3">View all answers</a>
                    {{--@if(isset($back))
                        <a href="{{ route($back) }}" class="btn btn-outline-primary mb-3 ml-auto">Dashboard</a>
                    @endif--}}
                </div>

                <div class="card">
                    <div class="card-header{{-- d-flex align-items-center--}}">
                        <div>Create Answers for Question: </div>
                        <div><strong>{{ $question->text }}</strong></div>
                        {{--<a href="{{ route('questions.show', ['question' => $question->id]) }}"
                           class="btn btn-secondary ml-auto">View Question</a>--}}
                    </div>
                    <div class="card-body">


                        {{--@if(count($answers))
                            <div class="row">
                                <div class="col">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Text</th>
                                                <th>Is Correct</th>
                                                <th>Updated</th>
                                                <th>Created</th>
                                                <th>Question ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($answers as $answer)
                                            <tr>
                                                <td>{{ $answer->text }}</td>
                                                <td>{{ $answer->is_right }}</td>
                                                <td>{{ $answer->updated_at }}</td>
                                                <td>{{ $answer->created_at }}</td>
                                                <td>{{ $answer->question_id }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif--}}


                        <form action="{{ route('answers.store', ['question' => $question->id]) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="question" value="{{ $question->id }}">

                            <div class="form-group row">
                                <label for="text" class="col-sm-2 col-form-label">Answer</label>
                                <div class="col-sm-10">
                                    <input type="text" name="text" id="text" class="form-control">
                                    @if($errors->has('text'))
                                        <div class="invalid-feedback d-block">{{ $errors->first('text') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input type="hidden" class="form-check-input" name="is_correct" value="0">
                                        <input type="checkbox" class="form-check-input" name="is_correct" id="is_correct" value="1">
                                        <label class="form-check-label" for="is_correct">
                                            Is correct answer
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary ml-auto"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
