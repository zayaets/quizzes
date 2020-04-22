@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>

                <div class="card">
                    <div class="card-header">
                        Create Question
                    </div>
                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea name="text" id="text" cols="30" rows="5" class="form-control">{{old('text', '')}}</textarea>
                                @if($errors->has('text'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('text') }}</div>
                                @endif
                            </div>

                            <div class="d-flex">
{{--                                <input type="submit" value="Create Answers" class="btn btn-primary ml-auto">--}}
                                {{--                                <a href="{{ route('answers.create') }}" class="btn btn-primary ml-2">Create Answers <i class="fas fa-arrow-right"></i></a>--}}
                                <input type="submit" class="btn btn-success ml-auto" name="submit" value="Save and Close">
                                <input type="submit" class="btn btn-primary ml-2" name="submit" value="Create Answers">

                            </div>
                        </form>
                    </div>
                </div>

                {{--@if(isset($question))
                    @if(count($question->answers))
                        <div class="card">
                            <div class="card-header">
                                {{ $question->text }}
                            </div>
                            <div class="card-body">
                                <form action="{{ route('questions.update', ['question' => $question->id]) }}" method="post">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    @foreach($question->answers as $answer)
                                        <div class="form-group form-check">
                                            <input type="hidden" name="question[{{ $question->id }}][{{ $answer->id }}]" value="0">
                                            <input type="checkbox" name="question[{{ $question->id }}][{{ $answer->id }}]" value="1" id="answer-{{ $answer->id }}" class="form-check-input">
                                            <label for="answer-{{ $answer->id }}" class="form-check-label">{{ $answer->text }}</label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

                            </div>
                        </div>



                        <table class="table">
                            <thead --}}{{--class="thead-dark"--}}{{-->
                            <tr class="bg-info">
                                <th>ID</th>
                                <th>Text</th>
                                <th>Questions ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($question->answers as $answer)
                                <tr>
                                    <td>{{ $answer->id }}</td>
                                    <td>{{ $answer->text }}</td>
                                    <td>{{ $answer->question_id }}</td>
                                    <td>{{ $answer->is_right }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            --}}{{--                        {{ $questions->links() }}--}}{{--
                        </div>
                    @else
                        <p>Question has no answers</p>
                    @endif
                @endif--}}
            </div>
        </div>
    </div>
@endsection
