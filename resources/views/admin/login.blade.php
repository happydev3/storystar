@extends('admin.layout.master')

@section('header')
    @include('admin.components.header-before-login')
@stop

@section('bodyContent')




        <!-- MAIN CONTENT -->
        <div id="content" class="container"  style="text-align: center;margin-top: 10%;">

            <div class="row">

                {{--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">--}}
                <div class="col-md-4 col-md-offset-4">
                    <div class="well no-padding">

                        {{--<div style="text-align: center;margin-top: 15px;">--}}
                            {{--<img src="{{app_assets('images/welcome-logo.png')}}" alt="{{config('app.name')}}">--}}

                        {{--</div>--}}
                        <form class="smart-form client-form" id="login-form" method="POST"
                              action="{{ route('admin-login') }}">
                            {{ csrf_field() }}
                            <header style="font-weight: bold;">

                                Admin Login
                            </header>




                            <fieldset  style="text-align: left">


                                @if ($errors->has('email')|| $errors->has('username'))

                                    <div class="alert alert-danger fade in">
                                        <i class="fa-fw fa fa-times"></i>
                                        <strong></strong>
                                        {{ $errors->first('email') }}
                                        {{ $errors->first('username') }}
                                    </div>

                                @endif

                                @if ($errors->has('password'))

                                    <div class="alert alert-danger fade in">
                                        <i class="fa-fw fa fa-times"></i>
                                        <strong></strong>
                                        {{ $errors->first('password') }}
                                    </div>

                                @endif


                                <section>
                                    <label class="label">E-mail/username</label>
                                    <label class="input">
                                        <i class="icon-append fa fa-user"></i>
                                        <input id="email" type="text" class="form-control" name="email"
                                               value="{{ old('email') }}" required autofocus>

                                        <b class="tooltip tooltip-top-right">
                                            <i class="fa fa-user txt-color-teal"></i>
                                            Please enter email address/username
                                        </b>


                                    </label>
                                </section>

                                <section>
                                    <label class="label">password</label>
                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i>
                                            Enter your password</b>
                                    </label>
                                    <div class="note">
                                        <a href="{{ route('admin-password-request') }}">
                                            Forgot password?
                                        </a>

                                    </div>


                                </section>

                                <section>
                                    <label class="checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <i></i>Stay logged in</label>
                                </section>
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>


                            </footer>
                        </form>


                    </div>

                </div>
            </div>
        </div>









@endsection
@push('js')
<script type="text/javascript">
    runAllForms();
    $(function () {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                email: {
                    required: true,

                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                }
            },

            // Messages for form validation
            messages: {
                email: {
                    required: 'Please enter your email address/username',
                    email: 'Please enter a VALID email address'
                },
                password: {
                    required: 'Please enter your password'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });
</script>
@endpush