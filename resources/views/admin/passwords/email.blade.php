@extends('admin.layout.master')

@section('header')
    @include('admin.components.header-before-login')
@stop

@section('bodyContent')
    <div id="main" role="main">

        <div id="content" class="container">

            <div class="row">

                <div class="col-md-4 col-md-offset-3">
                    <div class="well no-padding">


                        <form id="forgot-password-form" class="smart-form client-form" method="POST"
                              action="{{ route('admin-password-email') }}">
                            {{ csrf_field() }}
                            <header>
                                Forgot Password
                            </header>


                            <fieldset>


                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif


                                @if ($errors->has('email'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif


                                <section>
                                    <label class="label">Enter your email address</label>
                                    <label class="input"> <i class="icon-append fa fa-envelope"></i>

                                        <input id="email" type="email" name="email" value="{{ old('email') }}">

                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-envelope txt-color-teal"></i>
                                            Please enter email address for password reset
                                        </b>
                                    </label>
                                </section>
                                <section>
										<span class="timeline-seperator text-center text-primary"> <span
                                                    class="font-sm">OR</span>
                                </section>
                                <section>
                                    <label class="label">Your Username</label>
                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                        <input id="username" type="text" name="username" value="{{ old('username') }}">

                                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i>
                                            Enter
                                            your username</b> </label>

                                </section>

                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-refresh"></i>
                                    Send Me Link
                                </button>
                            </footer>
                        </form>

                    </div>

                    <h5 class="text-center"> - Or -</h5>


                    <ul class="list-inline text-center">

                        <li style="width:100%;">
                            <a style="width:100%;" href="{{route('admin-login')}}" class="btn btn-danger btn-sm">Go To
                                Login</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>


@endsection
