@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Dashboard</h1>
                    Here you can view all Questions created by you
                </div>

                <div class="card-body">
                    <div class="d-flex mb-3">
                        @can('create', \App\Question::class)
                            <a href="{{ route('questions.create') }}" class="btn btn-primary"
                               data-toggle="tooltip" title="Create Question"><i class="fas fa-plus"></i></a>
                        @endcan
                    </div>

                    @if(isset($message))
                        <div class="alert alert-success">{{ $message }}</div>
                    @endif

                    @if(isset($questions))
                        <table class="table">
                            <thead {{--class="thead-dark"--}}>
                            <tr class="thead-light">
                                <th>ID</th>
                                <th>Text</th>
                                <th>User ID</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $question->id }}</td>
                                    <td><a href="{{ route('questions.show', ['question' => $question->id]) }}">{{ $question->text }}</a></td>
                                    <td>{{ $question->user_id }}</td>
                                    <td>
                                        @can('update', $question)
                                            <a href="{{ route('questions.edit', ['question' => $question->id]) }}" class="btn btn-info text-light"
                                               data-toggle="tooltip" title="Edit question"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('delete', $question)
                                            <form action="{{ route('questions.destroy', ['question' => $question->id]) }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_method" value="delete">
                                                <button type="submit" class="btn btn-danger"
                                                        data-toggle="tooltip" title="Delete question"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endcan
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif
                    {{--@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
