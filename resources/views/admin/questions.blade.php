@extends('layouts.app')

@section('content')
    <div class="container">
        @includeIf('templates.admin_nav')

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    {{--<div class="card-header d-flex justify-content-center">
                        <h1>Questions</h1>
                    </div>--}}
                    <div class="card-body">

                        @includeIf('templates.session_messages')

                        @if(isset($questions))
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">@sortablelink('id', 'ID')</th>
                                    <th scope="col">@sortablelink('title', 'Title')</th>
                                    <th scope="col">@sortablelink('text', 'Text')</th>
                                    <th scope="col">@sortablelink('status.title', 'Status')</th>
                                    <th scope="col">@sortablelink('owner.name', 'User')</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($questions as $question)
                                    <tr>
                                        <th scope="row">{{ $question->id }}</th>
                                        <td><a href="{{ route('admin.question', ['question' => $question->id ]) }}">{{ $question->title }}</a></td>
                                        <td>
                                            {{ \Illuminate\Support\Str::limit($question->text, 50, ' (...)') }}
                                        </td>
                                        <td>{{ $question->status->title }}</td>
                                        <td>{{ $question->owner->name }}</td>
                                        {{--<td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-light text-dark dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item" data-toggle="collapse" data-target="#collapse-{{ $question->id }}">Button</button>
                                                    <a href="#" class="dropdown-item" id="popover1">the popover link</a>
                                                    <div id="popover-head" class="hide">
                                                        some title
                                                    </div>
                                                    <div id="popover-content" class="hide">
                                                        <!-- MyForm -->
                                                    </div>
                                                    <a href="#" class="dropdown-item">Link 1</a>
                                                    <a href="#" class="dropdown-item">Link 1</a>
                                                </div>
                                            </div>
                                        </td>--}}
                                        <td>
                                            <div class="d-flex">
                                                {{--<form action="{{ route('question.publish', ['question' => $question->id]) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary">Publish</button>
                                                </form>

                                                <form action="{{ route('question.unpublish', ['question' => $question->id]) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger">Unpublish</button>
                                                </form>--}}
                                            </div>
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
