@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-outline-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>

                <div class="card">
                    <div class="card-header text-center d-flex align-items-center">
                        <h5>Edit Question</h5>
                        <a href="{{ route('answers.index', ['question' => $question->id]) }}" class="btn btn-info text-light ml-auto">Edit Answers</a>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('questions.update', ['question' => $question->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $question->title) }}">
                                @error('title')
                                    <div class="invalid-feedback d-block">{{ $errors->first('title') }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="text">Text</label>
                                <textarea name="text" id="text" cols="30" rows="5" class="form-control">{{old('text', $question->text)}}</textarea>
                                @error('text')
                                    <div class="invalid-feedback d-block">{{ $errors->first('text') }}</div>
                                @enderror
                            </div>

                            <div class="d-flex">
                                <input type="submit" class="btn btn-success ml-auto" name="submit" value="Save and Close">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
