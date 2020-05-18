@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                @includeIf('templates.admin_nav')

                <p>Here is an admin panel</p>
                {{--<div class="card">
                    <div class="card-body"></div>
                </div>--}}
            </div>
        </div>
    </div>
@endsection
