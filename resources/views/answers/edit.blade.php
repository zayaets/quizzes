@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>

                <div class="card">
                    <div class="card-header">
                        Edit Answer:
{{--                        <div><strong>{{ $question->text }}</strong></div>--}}
                    </div>
                    <div class="card-body">

                        @if(!empty($message))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif

                        {{--@if(count($answers))
                            <div class="row">
                                <div class="col">
                                    <table class="table">
                                        <thead>
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


                        <form action="{{ route('answers.update', ['answer' => $answer->id]) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
{{--                            <input type="hidden" name="question_id" value="{{ $question->id }}">--}}

                            <div class="form-group row">
                                <label for="text" class="col-sm-2 col-form-label">Answer</label>
                                <div class="col-sm-10">
                                    <input type="text" name="text" id="text" class="form-control" value="{{ old('text', $answer->text) }}">
                                    @if($errors->has('text'))
                                        <div class="invalid-feedback d-block">{{ $errors->first('text') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input type="hidden" class="form-check-input" name="is_right" value="0">
                                        <input type="checkbox" class="form-check-input" name="is_right" id="is_right" value="1"
                                            {{ ($answer->is_right) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_right">
                                            Is correct answer
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Save</button>
                                {{--<a href="{{ route('questions.show', ['question' => $question->id]) }}"
                                   class="btn btn-secondary ml-2">View Question</a>--}}
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
