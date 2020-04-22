@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-auto" style="width: 18rem; ">
                    <img src="{{ asset('storage//images/pig.jpg') }}" class="card-img-top img-thumbnail" alt="Avatar">
                    <div class="card-header text-center">
                        <h4>{{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Statistics:</h5>
                        <p class="card-text">Published questions: 18</p>
                        <p class="card-text">Answered questions: 24</p>
                        <a href="{{ route('home') }}" class="btn btn-primary d-block mx-auto">Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



