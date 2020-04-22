@extends('layouts.app')

@section('content')
    <div class="container">
        @includeIf('templates.admin_nav')

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">
                        <h1>Questions</h1>
                    </div>
                    <div class="card-body">
                        @if(session('message')['status'] === 'error')
                            <div class="alert alert-danger">
                                {{ session('message')['text'] }}
                            </div>
                        @elseif(session('message')['status'] === 'success')
                            <div class="alert alert-success">
                                {{ session('message')['text'] }}
                            </div>
                        @endif

                        @if(isset($questions))
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Text</th>
                                    <th scope="col">Published</th>
                                    <th scope="col">User</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <th scope="row">{{ $question->id }}</th>
                                        <td>{{ $question->text }}</td>
                                        <td>{{ $question->published }}</td>
                                        <td>{{ $question->owner->name }}</td>
                                        <td>
                                            <form action="{{ route('question.publish', ['question' => $question->id]) }}" method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary">Publish</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('question.unpublish', ['question' => $question->id]) }}" method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger">Unpublish</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $questions->appends(request()->except('page'))->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
