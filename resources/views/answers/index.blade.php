@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 d-flex">
                <a href="{{ route('home') }}" class="btn btn-primary mb-3">Dashboard</a>
                <a href="{{ route('answers.create', ['question' => $question->id]) }}" class="btn btn-primary ml-auto mb-3"><i class="fas fa-plus"></i></a>
            </div>
            <div class="col-md-8">
                @if(isset($message))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif

                @if(isset($answers))
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Text</th>
                            <th>Is Right</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Question ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($answers as $answer)
                            <tr>
                                <td>{{ $answer->id }}</td>
                                <td>
                                    <a href="{{ route('answers.show', ['answer' => $answer->id]) }}">{{ $answer->text }}</a>
                                </td>
                                <td>{{ $answer->is_right }}</td>
                                <td>
                                    <a href="{{ route('answers.edit', ['answer' => $answer->id]) }}" class="btn btn-info text-light"><i class="fas fa-pencil-alt"></i></a>
                                </td>
                                <td>
                                    <form action="{{ route('answers.destroy', ['answer' => $answer->id]) }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">

                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>

                                </td>
                                <td>{{ $answer->question_id }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
{{--                        {{ $questions->links() }}--}}

                        {{--                        {{ $questions->lastPage() }}--}}
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
