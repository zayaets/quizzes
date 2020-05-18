@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row row-flex">
            <div class="col col-md-4">
                <div class="card text-center">
                    <img src="{{ asset('storage/images/avatar.jpg') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                {{--<tr>
                                    <th>ID</th>
                                    <th>Text</th>
                                    <th>Is Correct</th>
                                    <th>Questions ID</th>
                                </tr>--}}
                                </thead>
                                <tbody>
                                @foreach($stat as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    {{--<div class="container">
        <div class="team-single">
            <div class="row">
                <div class="col-lg-4 col-md-5 xs-margin-30px-bottom">
                    <div class="team-single-img">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                    </div>
                    <div class="bg-light-gray padding-30px-all md-padding-25px-all sm-padding-20px-all text-center">
                        <h4 class="margin-10px-bottom font-size24 md-font-size22 sm-font-size20 font-weight-600">Class Teacher</h4>
                        <p class="sm-width-95 sm-margin-auto">We are proud of child student. We teaching great activities and best program for your kids.</p>
                        <div class="margin-20px-top team-single-icons">
                            <ul class="no-margin">
                                <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fab fa-google-plus-g"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="team-single-text padding-50px-left sm-no-padding-left">
                        <h4 class="font-size38 sm-font-size32 xs-font-size30">Buckle Giarza</h4>
                        <p class="no-margin-bottom">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum voluptatem.</p>
                        <div class="contact-info-section margin-40px-tb">
                            <ul class="list-style9 no-margin">
                                <li>

                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="fas fa-graduation-cap text-orange"></i>
                                            <strong class="margin-10px-left text-orange">Degree:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p>Master's Degrees</p>
                                        </div>
                                    </div>

                                </li>
                                <li>

                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="far fa-gem text-yellow"></i>
                                            <strong class="margin-10px-left text-yellow">Exp.:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p>4 Year in Education</p>
                                        </div>
                                    </div>

                                </li>
                                <li>

                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="far fa-file text-lightred"></i>
                                            <strong class="margin-10px-left text-lightred">Courses:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p>Design Category</p>
                                        </div>
                                    </div>

                                </li>
                                <li>

                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="fas fa-map-marker-alt text-green"></i>
                                            <strong class="margin-10px-left text-green">Address:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p>Regina ST, London, SK.</p>
                                        </div>
                                    </div>

                                </li>
                                <li>

                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="fas fa-mobile-alt text-purple"></i>
                                            <strong class="margin-10px-left xs-margin-four-left text-purple">Phone:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p>(+44) 123 456 789</p>
                                        </div>
                                    </div>

                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-5 col-5">
                                            <i class="fas fa-envelope text-pink"></i>
                                            <strong class="margin-10px-left xs-margin-four-left text-pink">Email:</strong>
                                        </div>
                                        <div class="col-md-7 col-7">
                                            <p><a href="javascript:void(0)">addyour@emailhere</a></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <h5 class="font-size24 sm-font-size22 xs-font-size20">Professional Skills</h5>

                        <div class="sm-no-margin">
                            <div class="progress-text">
                                <div class="row">
                                    <div class="col-7">Positive Behaviors</div>
                                    <div class="col-5 text-right">40%</div>
                                </div>
                            </div>
                            <div class="custom-progress progress">
                                <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:40%" class="animated custom-bar progress-bar slideInLeft bg-sky"></div>
                            </div>
                            <div class="progress-text">
                                <div class="row">
                                    <div class="col-7">Teamworking Abilities</div>
                                    <div class="col-5 text-right">50%</div>
                                </div>
                            </div>
                            <div class="custom-progress progress">
                                <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:50%" class="animated custom-bar progress-bar slideInLeft bg-orange"></div>
                            </div>
                            <div class="progress-text">
                                <div class="row">
                                    <div class="col-7">Time Management </div>
                                    <div class="col-5 text-right">60%</div>
                                </div>
                            </div>
                            <div class="custom-progress progress">
                                <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:60%" class="animated custom-bar progress-bar slideInLeft bg-green"></div>
                            </div>
                            <div class="progress-text">
                                <div class="row">
                                    <div class="col-7">Excellent Communication</div>
                                    <div class="col-5 text-right">80%</div>
                                </div>
                            </div>
                            <div class="custom-progress progress">
                                <div role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:80%" class="animated custom-bar progress-bar slideInLeft bg-yellow"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12">

                </div>
            </div>
        </div>
    </div>--}}



@endsection


@push('styles')
{{--    <link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush