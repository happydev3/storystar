@extends('app.layout.page')

@section('bodyContent')

    <div class="container">
        <div class="row">
            <div class="nav-boxes middle-top-border">
                <div class="nav-boxes-inner middle-top-border-inner">
                    <div class="author-middle-bg publishstory_bg">
                        <h1 class="text-xs-center author-heading text-uppercase">Login to your account</h1>
                        <div class="publishstory-boxes">
                            <div class="our-story-info-box margin-bottom-remove">
                                <h1 class="story-info-title">Are you a new user?
                                    <a href="{{route("register")}}">Sign up</a></h1>
                                <div class="clearfix"></div>


                                <form class="login" id="loginForm" method="POST" action="{{route('login')}}">
                                    {{ csrf_field() }}

                                    @include('app.components.notification-messages')

                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            <i class="fa-fw fa fa-times"></i>
                                            <strong>Error!</strong>
                                            {!! $errors->first('email') !!}
                                        </div>
                                    @endif
                                    {{--@if ($errors->has('password'))--}}
                                    {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--@endif--}}

                                    <div class="form-select-boxes margin-bottom-remove">
                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Your Email</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">

                                                <input id="email" type="email" class="custom-input custom-select"
                                                       name="email"
                                                       value="{{ old('email') }}" required autofocus>

                                            </div>
                                        </div>

                                        <div class="form-select-left clearfix">
                                            <label class="title-padding">Password</label>
                                            <div class="pagination-left select-boxes-part-four remove-margin-right publish-select input-margin-remove">
                                                <input id="password" type="password" class="custom-input custom-select"
                                                       name="password" required>

                                            </div>
                                        </div>


                                        <div class="form-select-left clearfix font">
                                            <label class="title-padding">
                                                <input type="checkbox"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                Remember Me
                                            </label>
                                        </div>


                                        <div class="form-select-left clearfix font">
                                            <label class="title-padding">
                                                Forgot password? <a href="{{ route('password.request') }}">Click
                                                    here</a>
                                            </label>
                                        </div>


                                        <div class="form-select-left btn-style clearfix">
                                            <div class="text-xs-center btn btn-readstory publish-btn">
                                                <button type="submit">Login</button>
                                            </div>
                                        </div>


                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('app.components.footer')
        </div>
    </div>

    @if(isset($jsValidation)&& $jsValidation == true)
        {!! $validator or '' !!}
    @endif

@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        $(".custom-select").each(function () {
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function () {
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    })
</script>
@endpush

@push( 'meta-data' )

<meta property="og:url" content="http://www.storystar.com/"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="LOGIN TO YOUR ACCOUNT - Publish Story"/>
<meta property="og:description" content="LOGIN TO YOUR ACCOUNT - Publish Story."/>
<meta property="og:image" content="https://www.storystar.com/assets/app/images/storystarcomfb.jpg"/>


<meta name="description" content="LOGIN TO YOUR ACCOUNT - Publish Story. Story Star."/>
<meta name="keywords" content="login"/>
<meta name="distribution" content="global"/>
<meta name="robots" content="index,follow"/>
<meta name="language" content="en, gb"/> @endpush