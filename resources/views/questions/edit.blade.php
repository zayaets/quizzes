@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-outline-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        Edit Question
                        <a href="{{ route('answers.index', ['question' => $question->id]) }}" class="btn btn-info text-light ml-auto">Edit Answers</a>
                    </div>
                    <div class="card-body">




                        <form action="{{ route('questions.update', ['question' => $question->id]) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $question->title) }}">
                                @if($errors->has('title'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('title') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea name="text" id="text" cols="30" rows="5" class="form-control">{{old('text', $question->text)}}</textarea>
                                @if($errors->has('text'))
                                    <div class="invalid-feedback d-block">{{ $errors->first('text') }}</div>
                                @endif
                            </div>

                            <div class="d-flex">
                                <input type="submit" class="btn btn-success ml-auto" name="submit" value="Save and Close">
{{--                                <input type="submit" class="btn btn-primary ml-2" name="submit" value="Edit Answers">--}}
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
