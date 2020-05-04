@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('user.questions') }}" class="btn btn-outline-secondary mb-3" title="Back"><i class="fas fa-arrow-left"></i></a>

                @if(isset($question))
                    @if(count($question->answers))
                        <div class="card mb-3">
                            <div class="card-header d-flex align-items-center">
                                <h2>{{ $question->title }}</h2>
                            </div>
                            <div class="card-body">
                                <p>{{ $question->text }}</p>
                            </div>
                        </div>
                        <div class="table-responsive">
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
                        </div>
                    @else
                        <p>Question has no answers</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
