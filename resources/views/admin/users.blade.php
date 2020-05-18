@extends('layouts.app')

@section('content')
    <div class="container">

        @includeIf('templates.admin_nav')

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    @includeIf('templates.session_messages')

                    {{--<div class="card-header d-flex justify-content-center">
                        <h1>Users</h1>
                    </div>--}}
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

                        @if(isset($users))
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col"> @sortablelink('id', 'ID')</th>
                                    <th scope="col"> @sortablelink('name', 'Name')</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>
                                            <a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $users->appends(request()->except('page'))->render() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
