@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex">
                    <a href="{{ route('answers.index', ['question' => $question->id]) }}" class="btn btn-info text-light mb-3">View all answers</a>
                </div>

                <div class="card">
                    <div class="card-header text-center{{-- d-flex align-items-center--}}">
                        <h5>Create Answer</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('answers.store', ['question' => $question->id]) }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="question" value="{{ $question->id }}">

                            <div class="form-group row">
                                <label for="text" class="col-sm-2 col-form-label">Answer</label>
                                <div class="col-sm-10">
                                    <input type="text" name="text" id="text" class="form-control" value="{{ old('text') }}">
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
                                        <input type="checkbox" class="form-check-input" name="is_correct" id="is_correct" value="1"
                                            {{ old('is_correct') == 1 ? 'checked' : '' }}>
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
