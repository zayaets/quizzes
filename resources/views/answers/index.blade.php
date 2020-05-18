@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-header text-center">
                        <h4>Answers</h4>
                        <p>Here you can create Answers for the Question</p>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $question->title }}</h3>
                        <p class="card-text">{{ $question->text }}</p>
                    </div>
                </div>

                @includeIf('templates.session_messages')

                <div class="row">
                    <div class="col d-flex">
                        <a href="{{ route('answers.create', ['question' => $question->id]) }}"
                           class="btn btn-primary mb-3"
                           data-toggle="tooltip" title="Create answer"><i class="fas fa-plus"></i></a>

                        <a href="{{ route('user.questions') }}" class="btn btn-primary mb-3 ml-auto">My Questions</a>
                    </div>
                </div>

                @if(count($answers))
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Text</th>
                                    <th>Is Correct</th>
                                    <th></th>
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
                                        <td>{{ $answer->is_correct }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('answers.edit', ['answer' => $answer->id, 'question' => $question->id]) }}"
                                                   class="btn btn-info text-light"
                                                   data-toggle="tooltip" title="Edit answer"><i class="fas fa-pencil-alt"></i></a>

                                                <form action="{{ route('answers.destroy', ['answer' => $answer->id]) }}" method="post">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="_method" value="DELETE">

                                                    <button type="submit" class="btn btn-danger"
                                                            data-toggle="tooltip" title="Delete answer"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
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
                    </div>
                @else
                    <div class="alert alert-info">There're still no Answers here. You can add some now.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
