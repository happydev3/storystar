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


                        <form class="smart-form client-form" method="POST"
                              action="{{ route('admin-password-request') }}">

                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <header>
                                Reset Password
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


                                @if ($errors->has('password'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif


                                @if ($errors->has('password_confirmation'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif

                                <section>
                                    <label class="label">Enter your email address</label>
                                    <label class="input"> <i class="icon-append fa fa-envelope"></i>

                                        <input id="email" type="email" name="email"
                                               value="{{ $email or old('email') }}" required autofocus>

                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-envelope txt-color-teal"></i>
                                            Please enter email address for password reset
                                        </b>
                                    </label>
                                </section>
                                <section>
										<span class="timeline-seperator text-center text-primary"> <span
                                                    class="font-sm">New Password</span>
                                        </span>
                                </section>
                                <section>
                                    <label class="label">Password</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-key"></i>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                    </label>

                                </section>

                                <section>
                                    <label class="label">Confirm Password</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-key"></i>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                    </label>

                                </section>

                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i>
                                    Reset Password
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

