@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>My Questions</h4>
                        <p>Here you can view all the Questions you created</p>
                    </div>

                    <div class="card-body">
                        <div class="d-flex mb-3">

                            @can('create', \App\Question::class)
                                <a href="{{ route('questions.create') }}" class="btn btn-primary"
                                   data-toggle="tooltip" title="Create Question"><i class="fas fa-plus"></i></a>
                            @endcan
                        </div>

                        @includeIf('templates.session_messages')

                        @if(count($questions))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>@sortablelink('id', 'ID')</th>
                                        <th>@sortablelink('title', 'Title')</th>
                                        <th>@sortablelink('text', 'Text')</th>
{{--                                        <th>@sortablelink('user_id', 'User ID')</th>--}}
                                        <th>@sortablelink('owner.name', 'User')</th>
                                        <th>@sortablelink('created_at', 'Created')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td><a href="{{ route('user.question', ['question' => $question->id]) }}">{{ $question->title }}</a></td>
                                            <td>{{ \Illuminate\Support\Str::limit($question->text, 50, '(...)') }}</td>
{{--                                            <td>{{ $question->user_id }}</td>--}}
                                            <td>{{ $question->owner->name }}</td>
                                            <td>{{ $question->created_at }}</td>
                                            <td>
                                                <div class="d-flex justify-content-around">
                                                    @can('update', $question)
                                                        <a href="{{ route('questions.edit', ['question' => $question->id]) }}" class="btn btn-info text-light"
                                                           data-toggle="tooltip" title="Edit question"><i class="fas fa-pencil-alt"></i></a>
                                                    @endcan

                                                    @can('delete', $question)
                                                        <form action="{{ route('questions.destroy', ['question' => $question->id]) }}" method="post">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="_method" value="delete">
                                                            <button type="submit" class="btn btn-danger"
                                                                    data-toggle="tooltip" title="Delete question"><i class="fas fa-trash-alt"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{--                            {!! $question->appends(request()->except('page'))->render() !!}--}}
                            </div>
                        @else
                            <div class="alert alert-info">It's time to create a new Question</div>
                        @endif

                        {{--
                        <p>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Link with href
                            </a>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Button with data-target
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                            </div>
                        </div>
                        --}}

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
