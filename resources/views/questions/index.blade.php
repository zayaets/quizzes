@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(isset($questions))
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
{{--                                <th> @sortablelink('id', 'ID')</th>--}}
                                <th> @sortablelink('text', 'Text')</th>
                                <th> @sortablelink('user_id', 'Owner')</th>
                                <th> @sortablelink('created_at', 'Created')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>
                                        <a href="{{ route('questions.show', ['question' => $question->id]) }}">{{ $question->title }}</a>
                                        @if($question->answered)
                                            @if($question->answeredCorrect)
                                                <span class="badge badge-pill badge-success">Correct</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">Incorrect</span>
                                            @endif
                                        @endif

                                        <p>{{ \Illuminate\Support\Str::limit($question->text, 50, ' (...)') }}</p>
                                    </td>
                                    <td><a href="{{ route('users.show', ['user' => $question->owner->id]) }}">{{ $question->owner->name }}</a></td>
                                    <td>{{ $question->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $questions->appends(request()->except('page'))->render() !!}
{{--                        {{ $questions->links() }}--}}
{{--                        {{ $questions->lastPage() }}--}}
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
