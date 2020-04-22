@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(isset($users))
                    <table class="table">
                        <thead {{--class="thead-dark"--}}>
                        <tr class="bg-info">
                            <th>ID</th>
                            <th>Text</th>
                            <th>User ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
{{--                        {{ $questions->links() }}--}}
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection
